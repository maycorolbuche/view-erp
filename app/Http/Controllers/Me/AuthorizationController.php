<?php

namespace App\Http\Controllers\Me;

use App\Http\Controllers\Controller;
use App\Helpers\AuthorizationHelper;
use App\Models\Authorization;
use App\Models\AuthorizationStatus;
use Illuminate\Http\Request;
use App\Notifications\AuthorizationNotification;
use Illuminate\Support\Facades\Notification;
use App\Helpers\DataTableHelper;

class AuthorizationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pending = Authorization::getPendingResponse();
        return view('me.authorizations.index', compact('pending'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Authorization::with(['statuses', 'authorization_parent'])->find($id);
        if ($data) {
            if ($data->id_user != auth()->id()) {
                if (!in_array(auth()->id(), $data->statuses->pluck('id_user')->toArray())) {
                    return redirect()->route('me-authorizations')->with('error', 'Registro não encontrado!');
                }
            }
            $pending = Authorization::getPendingResponse();
            $edit = !!Authorization::query()->pendingResponse()->find($id);

            return view('me.authorizations.index', compact('data', 'pending', 'edit'));
        } else {
            return redirect()->route('me-authorizations')->with('error', 'Registro não encontrado!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $edit = !!Authorization::query()->pendingResponse()->find($id);
        if (!$edit) {
            return redirect()->back()->with('error', 'Você não tem permissão autorizar/negar este item!')->withInput();
        }

        try {
            $authorization = Authorization::find($id);
            if ($authorization) {
                $status = $request->status;
                if ($status == "") {
                    return redirect()->back()->with('error', 'Uma resposta deve ser escolhida!')->withInput();
                }

                $description = $request->description;
                if ($status == "N" && trim($description) == "") {
                    return redirect()->back()->with('error', 'O motivo da recusa deve ser informado!')->withInput();
                }

                $authorization_status = AuthorizationStatus::where(['id_authorization' => $id, 'id_user' => auth()->id()]);
                if ($authorization_status) {
                    $authorization_status->update(['id_authorization' => $id, 'id_user' => auth()->id(), 'approved' => $status == 'S', 'description' => $description]);
                    AuthorizationHelper::refresh($id);

                    try {
                        $this->sendMail($id);
                        return redirect()->route('me-authorizations.show', ['id' => $authorization->id_authorization])->with('success', 'Status atualizado com sucesso');
                    } catch (\Exception $e) {
                        return redirect()->back()->with('error', 'O status foi salvo com sucesso, porém, houve um erro ao enviar e-mail aos envolvidos.')->withInput();
                    }
                }
            } else {
                return redirect()->route('me-authorizations')->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function datatable()
    {
        return DataTableHelper::authorizations(Authorization::withMe());
    }

    public function sendMail($id_authorization)
    {

        $authorization = Authorization::where('id_authorization', $id_authorization)
            ->with(['clients', 'statuses', 'authorization_type', 'user'])
            ->first();

        foreach ($authorization->statuses as $user) {
            Notification::send($user, new AuthorizationNotification($authorization, 'status'));
        }
        Notification::send($authorization->user, new AuthorizationNotification($authorization, 'status'));
    }
}
