<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Notification;
use App\Models\UserNotification;
use App\Http\Requests\UserNotificationRequest;

class UserNotificationController extends Controller
{

    public function parent()
    {
        return view('users.notifications.parent');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $pid = $id;
        try {
            $user = User::with('users_notifications')->find($id);
            if ($user) {
                $user->id_notification = $user->users_notifications->keyBy('id_notification')->toArray();
                $notifications = Notification::orderBy('name')->get();
                return view('users.notifications.index', compact('pid', 'user', 'notifications'));
            } else {
                return redirect()->route('users-notifications')->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserNotificationRequest $request, $id)
    {
        if (!in_array('update', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para salvar nessa página!')->withInput();
        }

        try {
            $user = User::find($id);
            if ($user) {
                UserNotification::where('id_user', $user->id_user)->where('required', false)->delete();
                if ($request->id_notification && count($request->id_notification) > 0) {
                    foreach ($request->id_notification as $id_notification) {
                        UserNotification::firstOrCreate(['id_user' => $user->id_user, 'id_notification' => $id_notification]);
                    }
                }
                return redirect()->route('users-notifications.index', ['pid' => $id])->with('success', 'Registro salvo com sucesso');
            } else {
                return redirect()->route('users-notifications')->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }
}
