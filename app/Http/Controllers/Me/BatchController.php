<?php

namespace App\Http\Controllers\Me;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Expense;
use App\Models\Notification as NotificationModel;
use App\Helpers\BatchHelper;
use App\Helpers\DataTableHelper;
use Illuminate\Support\Facades\Auth;
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
        return view('me.batches.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $batch = Batch::where('id_user', Auth::id())->find($id);
        if ($batch) {
            $data = BatchHelper::data($id);
            if ($data) {
                return view('me.batches.index', $data);
            } else {
                return redirect()->route('me-batches')->with('error', 'Registro não encontrado!');
            }
        } else {
            return redirect()->route('me-batches')->with('error', 'Registro não encontrado!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $batch = Batch::find($id);
            if ($batch) {
                if (!$batch->active) {
                    return redirect()->back()->with('error', 'Este lote não pode ser desfeito, pois já foi processado!')->withInput();
                }
                if ($batch->revised_status == 'analyzing') {
                    return redirect()->back()->with('error', 'Este lote não pode ser desfeito, pois está em processo de revisão!')->withInput();
                }
                if ($batch->revised_status !== 'pending') {
                    return redirect()->back()->with('error', 'Este lote não pode ser desfeito, pois já foi revisado!')->withInput();
                }
                Expense::where('id_batch', $id)->update(['id_batch' => null]);
                $batch->delete();
                $this->sendMail($id);
                return redirect()->route('me-batches')->with('success', 'Registro apagado com sucesso');
            } else {
                return redirect()->route('me-batches')->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function datatable()
    {
        return DataTableHelper::batches(['id_user' => Auth::id()]);
    }


    public function sendMail($id_batch)
    {
        $notifications = NotificationModel::where('slug', 'batch')->with(['users_notifications.user'])->first();
        foreach ($notifications->users_notifications as $notification) {
            Notification::send($notification->user, new BatchNotification($id_batch, 'delete'));
        }
    }
}
