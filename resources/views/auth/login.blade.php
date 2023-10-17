@extends('layouts.auth')

@section('content')
    <div class="row mb15 table-layout">

        <div class="col-xs-6 va-m pln">
            <a href="dashboard.html" title="Return to Dashboard">
                <img src="{{ asset('assets/img/logos/logo-white.png') }}" style="height: 50px;">
            </a>
        </div>

        <div class="col-xs-6 text-right va-b pr5">
            <div class="login-links">
                <a href="pages_login.html" title="Sign In">Esqueci a Senha</a>
            </div>

        </div>

    </div>

    <div class="panel panel-info mt10 br-n">

        <form method="post" action="{{ route('login.auth') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

            <div class="panel-body bg-light p30">
                <div class="row">
                    <div class="col-sm-12 pr30">

                        @include('layouts.partials.messages')

                        <div class="section">
                            <label for="username" class="field-label text-muted fs18 mb10">Usuário</label>
                            <label for="username" class="field prepend-icon">
                                <input type="text" name="username" id="username" class="gui-input"
                                    placeholder="Digite seu usuário" value="{{ old('username') }}">
                                <label for="username" class="field-icon">
                                    <i class="fa fa-user"></i>
                                </label>
                            </label>
                            @if ($errors->has('username'))
                                <label for="username" class="mt5">
                                    <span class="text-danger">{{ $errors->first('username') }}</span>
                                </label>
                            @endif
                        </div>


                        <div class="section">
                            <label for="username" class="field-label text-muted fs18 mb10">Senha</label>
                            <label for="password" class="field prepend-icon">
                                <input type="password" name="password" id="password" class="gui-input"
                                    placeholder="Digite sua senha">
                                <label for="password" class="field-icon">
                                    <i class="fa fa-lock"></i>
                                </label>
                            </label>
                            @if ($errors->has('password'))
                                <label for="password" class="mt5">
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                </label>
                            @endif
                        </div>


                    </div>
                </div>
            </div>

            <div class="panel-footer clearfix p10 ph15">
                <button type="submit" class="button btn-primary mr10 pull-right">Entrar</button>
                <label class="switch switch-round block switch-primary pull-left input-align mt10">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember" data-on="SIM" data-off="NÃO"></label>
                    <span>Mantenha-me conectado</span>
                </label>
            </div>

        </form>
    </div>
@endsection
