<?php

namespace App\Http\Controllers\Batch;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Helpers\ExpenseHelper;
use App\Http\Requests\BatchRequest;
use Illuminate\Support\Facades\Auth;

class BatchController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = Expense::with(['category', 'clients', 'payment_method'])
            ->where('id_user', Auth::id())
            ->whereNull('id_batch')
            ->orderBy('date', 'desc')
            ->get();

        return view('batches.index', compact('expenses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BatchRequest $request)
    {
        if (!in_array('store', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para cadastrar nessa página!')->withInput();
        }

        try {
            $id_batch = ExpenseHelper::batch($request->all());
            return redirect()->route('me-batches.show', ['id' => $id_batch])->with('success', 'Lote gerado com sucesso');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }
}
