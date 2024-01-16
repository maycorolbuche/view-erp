<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserCashHistory;
use App\Models\Transaction;
use Carbon\Carbon;
use DataTables;

class CashFlowController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cash-flow.index');
    }


    public function datatable()
    {

        $data = Transaction::latest()->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('amount', function ($row) {
                $amount_data = "<span class='" . ($row->amount < 0 ? "text-danger" : ($row->amount > 0 ? "text-info" : "")) . "'>" . number_format($row->amount, 2, ',', '.') . "</span>";
                return "<span style='display:none'>" . $row->amount . "</span>" . $amount_data;
            })
            ->addColumn('date', function ($row) {
                return ($row->created_at ? '<span style="display:none">' . $row->created_at . '</span>' . Carbon::parse($row->created_at)->format('d/m/Y') : '');
            })
            ->addColumn('description', function ($row) {
                $details = "";
                if ($row->id_batch) {
                    $details .= " <span class='label label-dark'>#Lote " . $row->id_batch . "</span>";
                }
                return $row->description . $details;
            })
            ->rawColumns(['date', 'amount', 'description'])
            ->make(true);
    }
}
