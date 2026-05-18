@extends('layouts.auth')

@section('side-card')
    <!-- Texto central -->
    <div class="px-4">
        <h1 class="display-5 fw-bold mb-4">
            Bem-vindo de volta! 👋
        </h1>

        <p class="fs-5 mb-0">
            Acesse sua conta para continuar
            acompanhando o que acontece na View.
        </p>
    </div>

    <!-- Rodapé -->
    <div class="d-flex align-items-start gap-3">

        <div class="border rounded-4 p-3">
            <i class="bi bi-shield-check"></i>
        </div>

        <div>
            <h5 class="fw-semibold mb-2">
                Segurança em primeiro lugar
            </h5>

            <p class="mb-0">
                Nossas informações são protegidas com os
                mais altos padrões de segurança.
            </p>
        </div>

    </div>
@endsection

@section('content')
    <x-card>

        <div class="p-4 p-lg-5">

            <!-- Ícone -->
            <div class="text-center">

                <h2 class="fw-bold mb-2">
                    Acessar sua conta
                </h2>

                <p class="text-muted mb-0">
                    Informe suas credenciais para entrar na intranet
                </p>

            </div>

            <!-- Form -->
            <x-form :action="route('login.auth')">

                @include('layouts.partials.messages')

                {{-- USUÁRIO --}}
                <div class="mb-4">

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
                <div class="mb-4">

                    <label for="password" class="form-label fw-semibold">
                        Senha
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-lock"></i>
                        </span>

                        <input type="password" id="password" name="password" class="form-control"
                            placeholder="Digite sua senha">

                        <button type="button" class="btn btn-outline-secondary">
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
                <div class="d-grid mb-4">
                    <button type="submit" class="btn btn-danger btn-lg">
                        Entrar
                    </button>
                </div>

                <!-- Divider -->
                <div class="d-flex align-items-center gap-3 mb-4">

                    <hr class="flex-grow-1">

                    <span class="text-muted">
                        ou
                    </span>

                    <hr class="flex-grow-1">

                </div>

                <!-- Microsoft -->
                <div class="d-grid">

                    <button type="button"
                        class="btn btn-outline-secondary btn-lg d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-microsoft"></i>
                        Entrar com Microsoft
                    </button>

                </div>

                @if (env('APP_ENV') != 'production' || env('APP_DEBUG') == '1')
                    <div class="p-2 d-flex align-items-center justify-content-center gap-10">
                        <span class='badge badge-danger'>{{ env('APP_ENV') }}</span>
                        <span class='badge badge-warning'>{{ env('APP_DEBUG') ? 'debug' : '' }}</span>
                    </div>
                @endif

            </x-form>

        </div>
    </x-card>
@endsection
