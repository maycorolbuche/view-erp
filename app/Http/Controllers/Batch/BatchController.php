<?php

namespace App\Http\Controllers\Batch;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Expense;
use App\Models\Notification as NotificationModel;
use App\Helpers\ExpenseHelper;
use App\Http\Requests\BatchRequest;
use App\Helpers\UserHelper;
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

        $user_cash = UserHelper::getCash(auth()->id());

        return view('batches.index', compact('expenses', 'user_cash'));
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

        $id_batch = ExpenseHelper::batch($request->all());
        try {
            $this->sendMail($id_batch);
        } catch (\Exception $e) {
            /*
            $message = $e->getMessage();
            $message = str_replace("<", "(", $message);
            $message = str_replace(">", ")", $message);
            return redirect()->back()->with('error', $message)->withInput();
            */
        }
        return redirect()->route('me-batches.show', ['id' => $id_batch])->with('success', 'Lote gerado com sucesso');
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
