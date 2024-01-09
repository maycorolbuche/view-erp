<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Helpers\BatchHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{

    public function batch($id)
    {
        $id = Crypt::decrypt($id);
        $data = BatchHelper::data($id);
        if ($data) {
            //return view('pdf.batch', $data);
            $pdf = Pdf::loadView('pdf.batch', $data);
            $pdf->setPaper('a4');

            return $pdf->stream('batch_' . $id . '.pdf');
        } else {
            return view('errors.document_not_found');
        }
    }

    function data($id)
    {
        $data = Batch::where('id_user', Auth::id())->with([
            'user.users_cash',
            'categories' => function ($query) {
                $query->orderBy('short_name');
            },
            'clients' => function ($query) {
                $query->orderBy('short_name');
            },
            'expenses' => function ($query) {
                $query->orderBy('date');
            },
            'discounts'
        ])->find($id);
        if ($data) {
            $chart_categories = $data->categories->map(function ($category) {
                return [
                    'name' => $category['short_name'],
                    'y' => floatval($category['pivot']['amount']),
                ];
            })->toArray();

            $chart_clients = $data->clients->map(function ($category) {
                return [
                    'name' => $category['short_name'],
                    'y' => floatval($category['pivot']['amount']),
                ];
            })->toArray();

            return compact('data', 'chart_categories', 'chart_clients');
        } else {
            return null;
        }
    }
}
