<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordChangeRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordChangeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('me.password-change.index');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PasswordChangeRequest $request)
    {
        try {
            $user = Auth::user();

            if (Hash::check($request->current_password, $user->password)) {
                $user->forceFill([
                    'password' => $request->new_password,
                    'remember_token' => Str::random(60),
                ])->save();

                return redirect()->route('me-password-change')->with('success', 'Senha alterada com sucesso!');
            } else {
                return back()->withErrors(['current_password' => 'A senha atual não corresponde.'])->withInput();
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }
}
