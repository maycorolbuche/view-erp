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
                    Recuperar acesso
                </h3>

                <p class="text-muted mb-0">
                    Informe seu e-mail para receber as instruções de recuperação de senha.
                </p>
            </div>

            <x-form :action="route('password.email')">
                @include('layouts.partials.messages')

                <div class="mb-2">

                    <label for="email" class="form-label fw-semibold">
                        E-mail
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-envelope"></i>
                        </span>

                        <input type="email" id="email" name="email" class="form-control"
                            placeholder="Digite seu e-mail" value="{{ old('email') }}">

                    </div>

                    @if ($errors->has('email'))
                        <div class="mt-2 fs-6">
                            <span class="text-danger">
                                {{ $errors->first('email') }}
                            </span>
                        </div>
                    @endif

                </div>


                <div class="d-grid mb-1">
                    <button type="submit" class="btn btn-danger btn-lg">
                        Enviar
                    </button>
                </div>

                <div class="text-center">
                    <a href="{{ route('login') }}">
                        Voltar para o login
                    </a>
                </div>
            </x-form>

        </div>
    </x-card>
@endsection
