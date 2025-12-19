<?php

namespace App\Http\Controllers\Batch;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Expense;
use App\Models\Notification as NotificationModel;
use App\Helpers\ExpenseHelper;
use App\Http\Requests\BatchRequest;
use Illuminate\Support\Facades\Notification;
use App\Notifications\BatchNotification;

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
            ->me()
            ->withoutBatch()
            ->activeAuthorization()
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
            $this->sendMail($id_batch);
            return redirect()->route('me-batches.show', ['id' => $id_batch])->with('success', 'Lote gerado com sucesso');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function sendMail($id_batch)
    {
        $batch = Batch::find($id_batch);
        $notifications = NotificationModel::where('slug', 'batch_review')->with(['users_notifications.user'])->first();
        foreach ($notifications->users_notifications as $notification) {
            Notification::send($notification->user, new BatchNotification($batch));
        }
    }
}
