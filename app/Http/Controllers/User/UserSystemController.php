<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\System;
use App\Models\UserSystem;
use Illuminate\Http\Request;
use App\Helpers\Root;

class UserSystemController extends Controller
{
    public function parent()
    {
        return view('users.systems.parent');
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
            $user = User::find($id);
            if ($user) {
                $systems = System::orderBy('name')->get();
                $users_systems = UserSystem::where('id_user', $id)->get()->keyBy('id_system');

                return view('users.systems.index', compact('pid', 'user', 'systems', 'users_systems'));
            } else {
                return redirect()->route('users-systems')->with('error', 'Registro não encontrado!');
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
    public function update(Request $request, $id)
    {
        if (!in_array('update', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para salvar nessa página!')->withInput();
        }

        try {
            $user = User::find($id);
            if ($user) {

                if ($user->root) {
                    return redirect()->back()->with('error', 'Não é possível alterar os sistemas do usuário raiz!');
                } else {
                    UserSystem::where('id_user', $id)->delete();
                    if (isset($request->system)) {
                        foreach (array_keys($request->system) as $id_system) {
                            UserSystem::create(['id_user' => $id, 'id_system' => $id_system]);
                        }
                    }
                }
                Root::run();
                return redirect()->route('users-systems.index', ['pid' => $id])->with('success', 'Registro salvo com sucesso');
            } else {
                return redirect()->route('users-systems')->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }
}
