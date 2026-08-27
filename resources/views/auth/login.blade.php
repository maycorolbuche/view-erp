@extends('layouts.auth')

@section('side-card')
    <div class="d-flex flex-column justify-content-end h-100">
        <div class="d-flex align-items-center gap-3">

            <div class="border border-secondary rounded-2 p-2 px-3 text-secondary fs-4">
                <i class="bi bi-shield-check"></i>
            </div>

            <div>
                <h6 class="fw-semibold mb-2">
                    Ambiente seguro
                </h6>

                <p class="mb-0">
                    Suas informações estão protegidas.
                </p>
            </div>

        </div>
    </div>
@endsection

@section('content')
    <x-card>

        <div class="p-4 p-lg-5">

            <div class="text-center mb-4">

                <h3 class="fw-bold mb-2">
                    Acessar sua conta
                </h3>

                <p class="text-muted mb-0">
                    Informe suas credenciais para entrar na intranet
                </p>

            </div>

            <!-- Form -->
            <x-form :action="route('login.auth')">

                @include('layouts.partials.messages')

                {{-- USUÁRIO --}}
                <div class="mb-2">

                    <label for="username" class="form-label fw-semibold">
                        Usuário
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-person"></i>
                        </span>

                        <input type="text" id="username" name="username" class="form-control"
                            placeholder="Digite seu usuário" value="{{ old('username') }}">

                    </div>

                    @if ($errors->has('username'))
                        <div class="mt-2 fs-6">
                            <span class="text-danger">
                                {{ $errors->first('username') }}
                            </span>
                        </div>
                    @endif

                </div>

                {{-- SENHA --}}
                <div class="mb-2">


                    <label for="password" class="form-label fw-semibold">
                        Senha
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-lock"></i>
                        </span>

                        <input type="password" id="password" name="password" class="form-control"
                            placeholder="Digite sua senha">

                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password', this)">
                            <i class="bi bi-eye"></i>
                        </button>

                    </div>

                    @if ($errors->has('password'))
                        <div class="mt-2 fs-6">
                            <span class="text-danger">
                                {{ $errors->first('password') }}
                            </span>
                        </div>
                    @endif

                </div>

                <!-- Opções -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember"
                            {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            Lembrar-me
                        </label>
                    </div>

                    <a href="{{ route('password.request') }}">
                        Esqueci minha senha
                    </a>

                </div>

                <!-- Botão -->
                <div class="d-grid mb-1">
                    <button type="submit" class="btn btn-danger btn-lg">
                        Entrar
                    </button>
                </div>

                @if (env('APP_ENV') != 'production' || env('APP_DEBUG') == '1')
                    <div class="p-2 d-flex align-items-center justify-content-center gap-1">
                        <span class='badge text-bg-danger'>{{ env('APP_ENV') }}</span>
                        <span class='badge text-bg-warning'>{{ env('APP_DEBUG') ? 'debug' : '' }}</span>
                    </div>
                @endif

            </x-form>

        </div>
    </x-card>
@endsection
