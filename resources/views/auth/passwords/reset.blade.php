@extends('layouts.auth')

@section('header-links')
    <a href="{{ route('login') }}" class="active">Login</a>
    <span class="text-white"> | </span>
    <a href="{{ route('password.request') }}">Esqueci a Senha</a>
@endsection

@section('content')
    <form method="post" action="{{ route('password.reset') }}">
        {{ csrf_field() }}
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="panel-body bg-light p30">
            <div class="row">
                <div class="col-sm-12 pr30">

                    @include('layouts.partials.messages')
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="section">
                        <label for="username" class="field-label text-muted fs18 mb10">E-mail</label>
                        <label for="username" class="field prepend-icon">
                            <input type="email" name="email" class="gui-input" placeholder="Digite seu e-mail"
                                value="{{ $email ?? old('email') }}">
                            <label for="username" class="field-icon">
                                <i class="fa fa-envelope-o"></i>
                            </label>
                        </label>
                        @if ($errors->has('email'))
                            <label for="email" class="mt5">
                                <span class="text-danger">{{ $errors->first('email') }}</span>
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

                    <div class="section">
                        <label for="password_confirmation" class="field-label text-muted fs18 mb10">Confirmação de
                            Senha</label>
                        <label for="password_confirmation" class="field prepend-icon">
                            <input type="password" name="password_confirmation" class="gui-input"
                                placeholder="Repita sua senha">
                            <label for="password_confirmation" class="field-icon">
                                <i class="fa fa-lock"></i>
                            </label>
                        </label>
                        @if ($errors->has('password_confirmation'))
                            <label for="password_confirmation" class="mt5">
                                <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                            </label>
                        @endif
                    </div>

                </div>
            </div>
        </div>

        <div class="panel-footer clearfix p10 ph15">
            <button type="submit" class="button btn-primary mr10 pull-right">Confirmar</button>
        </div>

    </form>
    <!--
                                <div class="row m-t-40">
                                    <div class="col-md-4 col-md-offset-4">
                                        <h3 class="text-center m-b-20">backpack::base.reset_password</h3>
                                        <div class="nav-steps-wrapper">
                                            <ul class="nav nav-tabs nav-steps">
                                                  <li><a class="disabled text-muted"><strong>backpack::base.step 1.</strong> backpack::base.confirm_email</a></li>
                                                  <li class="active"><a><strong>backpack::base.step 2.</strong> backpack::base.choose_new_password</a></li>
                                            </ul>
                                        </div>
                                        <div class="nav-tabs-custom">
                                            <div class="tab-content">
                                              <div class="tab-pane active" id="tab_1">
                                                @if (session('status'))
    <div class="alert alert-success">
                                                        {{ session('status') }}
                                                    </div>
    @endif
                                                <form class="col-md-12 p-t-10" role="form" method="POST" action="{{ route('password.reset') }}">
                                                    {!! csrf_field() !!}

                                                    <input type="hidden" name="token" value="{{ $token }}">

                                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                                        <label class="control-label">backpack::base.email_address</label>

                                                        <div>
                                                            <input type="email" class="form-control" name="email" value="{{ $email ?? old('email') }}">

                                                            @if ($errors->has('email'))
    <span class="help-block">
                                                                    <strong>{{ $errors->first('email') }}</strong>
                                                                </span>
    @endif
                                                        </div>
                                                    </div>

                                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                                        <label class="control-label">backpack::base.new_password</label>

                                                        <div>
                                                            <input type="password" class="form-control" name="password">

                                                            @if ($errors->has('password'))
    <span class="help-block">
                                                                    <strong>{{ $errors->first('password') }}</strong>
                                                                </span>
    @endif
                                                        </div>
                                                    </div>

                                                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                                        <label class="control-label">backpack::base.confirm_new_password</label>
                                                        <div>
                                                            <input type="password" class="form-control" name="password_confirmation">

                                                            @if ($errors->has('password_confirmation'))
    <span class="help-block">
                                                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                                </span>
    @endif
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div>
                                                            <button type="submit" class="btn btn-block btn-primary">
                                                                backpack::base.change_password
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div class="clearfix"></div>
                                              </div>
                                            </div>
                                          </div>
                                    </div>
                                </div>
                                -->
@endsection
