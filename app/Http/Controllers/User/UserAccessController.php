<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\UserAccessRequest;

class UserAccessController extends Controller
{
    public function parent()
    {
        return view('users.access.parent');
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
                return view('users.access.index', compact('pid', 'user'));
            } else {
                return redirect()->route('users-access')->with('error', 'Registro não encontrado!');
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
    public function update(UserAccessRequest $request, $id)
    {
        if (!in_array('update', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para salvar nessa página!')->withInput();
        }

        unset($request["root"]);

        if (!$request->password) {
            unset($request["password"]);
        }

        try {
            $user = User::find($id);
            if ($user) {
                if ($user->root == true) {
                    unset($request["active"]);
                }

                $user->update($request->all());
                return redirect()->route('users-access.index', ['pid' => $id, 'user' => $user])->with('success', 'Registro salvo com sucesso');
            } else {
                return redirect()->route('users-access')->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }
}
