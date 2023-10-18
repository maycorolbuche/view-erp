@extends('layouts.auth')

@section('header-links')
    <a href="{{ route('login') }}" class="active">Login</a>
@endsection

@section('content')
    <form method="post" action="{{ route('password.email') }}">
        {{ csrf_field() }}

        <div class="panel-body bg-light p30">

            <div class="row">
                <div class="col-md-12 pr30">

                    @include('layouts.partials.messages')
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="section">
                        <label for="email" class="field-label text-muted fs18 mb10 ">E-mail</label>
                        <div class="smart-widget sm-right smr-80">
                            <label for="email" class="field prepend-icon">
                                <input type="email" name="email" class="gui-input" placeholder="Seu endereço de e-mail"
                                    value="{{ old('email') }}">
                                <label for="email" class="field-icon">
                                    <i class="fa fa-envelope-o"></i>
                                </label>
                            </label>
                            <button type="submit" class="button">Enviar</button>
                        </div>
                    </div>
                    <span>
                        Digite seu <b>e-mail</b> para receber as instruções de recuperação de senha.
                    </span>
                </div>

            </div>

        </div>
    </form>
@endsection
