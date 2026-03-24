@extends('layouts.auth')

@section('header-links')
    <a href="{{ route('password.request') }}">Esqueci a Senha</a>
@endsection

@section('content')
    <x-form :action="route('login.auth')">
        <div class="panel-body bg-light p30">
            <div class="row">
                <div class="col-sm-12 pr30">

                    @include('layouts.partials.messages')

                    <div class="section">
                        <label for="username" class="field-label text-muted fs18 mb10">Usuário</label>
                        <label for="username" class="field prepend-icon">
                            <input type="text" name="username" class="gui-input" placeholder="Digite seu usuário"
                                value="{{ old('username') }}">
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
                        <label for="password" class="field-label text-muted fs18 mb10">Senha</label>
                        <label for="password" class="field prepend-icon">
                            <input type="password" name="password" class="gui-input" placeholder="Digite sua senha">
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
            <label class="switch switch-round switch-primary pull-left input-align mt10">
                <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember"></label>
                <span>Mantenha-me conectado</span>
            </label>
        </div>

        @if (env('APP_ENV') != 'production' || env('APP_DEBUG') == '1')
            <div class="p5" style="display: flex;align-items: center;justify-content: center;gap: 10px;">
                <span class='badge badge-danger'>{{ env('APP_ENV') }}</span>
                <span class='badge badge-warning'>{{ env('APP_DEBUG') ? 'debug' : '' }}</span>
            </div>
        @endif

    </x-form>
@endsection
