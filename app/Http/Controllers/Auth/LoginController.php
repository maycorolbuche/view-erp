<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Display login page.
     * 
     * @return Renderable
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Handle account login request
     * 
     * @param LoginRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->getCredentials();
        $remember = $request->has('remember');

        $user = User::where('username', $credentials['username'] ?? null)->orWhere('email', $credentials['email'] ?? null)->first();
        if ($user) {
            if (empty($user->password)) {
                return redirect()
                    ->route('password.request')
                    ->with('email', $user->email)
                    ->withErrors('Você precisa cadastrar uma nova senha de acesso! Siga as instruções abaixo para criar sua senha.');
            }
        } else {
            return redirect()
                ->route('login')
                ->withInput()
                ->withErrors(trans('auth.failed'));
        }

        if (!app()->environment('local')) {
            if (!auth()->attempt($credentials, $remember)) {
                return redirect()
                    ->route('login')
                    ->withInput()
                    ->withErrors(trans('auth.failed'));
            }

            $user = auth()->user();
        } else {
            auth()->login($user, $remember);
        }

        if ($user->active <= 0) {
            auth()->logout();
            return redirect()
                ->route('login')
                ->withInput()
                ->withErrors("Usuário inativo. Entre em contato com o suporte!");
        }

        return $this->authenticated($request, $user);
    }

    /**
     * Handle response after user authenticated
     * 
     * @param Request $request
     * @param Auth $user
     * 
     * @return \Illuminate\Http\Response
     */
    protected function authenticated(Request $request, $user)
    {
        return redirect()->intended();
    }
}
