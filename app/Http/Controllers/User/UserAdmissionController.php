<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\UserAdmissionRequest;

class UserAdmissionController extends Controller
{

    protected $fillable = [
        'hire_date',
        'termination_date',
        'admission_notes',
    ];

    public function parent()
    {
        return view('users.admission.parent');
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
                return view('users.admission.index', compact('pid', 'user'));
            } else {
                return redirect()->route('users-admission')->with('error', 'Registro não encontrado!');
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
    public function update(UserAdmissionRequest $request, $id)
    {
        if (!in_array('update', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para salvar nessa página!')->withInput();
        }

        try {
            $user = User::find($id);
            if ($user) {
                $user->update($request->only($this->fillable));
                return redirect()->route('users-admission.index', ['pid' => $id, 'user' => $user])->with('success', 'Registro salvo com sucesso');
            } else {
                return redirect()->route('users-admission')->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }
}
