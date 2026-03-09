<?php

namespace App\Http\Controllers\Me;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Expense;
use App\Models\Notification as NotificationModel;
use App\Models\Authorization;
use App\Helpers\BatchHelper;
use App\Helpers\DataTableHelper;
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
        $batch = Batch::me()->find($id);
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
            $batch = Batch::me()->find($id);
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

                //Checa se alguma das despesas do lote possui autorização vencida. Se tiver, lote não pode ser desfeito.
                $auths = Expense::query()->batch($id)->inactiveAuthorization()->pluck('id_authorization')->toArray();
                if (count($auths) > 0) {
                    $authorizations = Authorization::whereIn('id_authorization', $auths)->get();
                    $message = "Não é possível desfazer este lote, pois ele possui autorizações vencidas!";
                    $message .= "<ul>";
                    foreach ($authorizations as $authorization) {
                        $message .= "<li>" . $authorization->description_details . "</li>";
                    }
                    $message .= "</ul>";
                    return redirect()->back()->with('error', $message)->withInput();
                }
                Expense::query()->batch($id)->update(['id_batch' => null, 'revised' => false]);
                $batch->delete();
                try {
                    $this->sendMail($id);
                } catch (\Exception $e) {
                }
                return redirect()->route('me-batches')->with('success', 'Lote desfeito com sucesso');
            } else {
                return redirect()->route('me-batches')->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function datatable()
    {
        return DataTableHelper::batches(Batch::me());
    }


    public function sendMail($id_batch)
    {
        $notifications = NotificationModel::where('slug', 'batch_review')->with(['users_notifications.user'])->first();
        foreach ($notifications->users_notifications as $notification) {
            Notification::send($notification->user, new BatchNotification($id_batch, 'delete'));
        }
    }
}
