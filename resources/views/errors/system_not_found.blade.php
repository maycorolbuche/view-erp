@extends('layouts.auth')

@section('header-links')
    <a href="{{ route('logout') }}">Desconectar</a>
    <span class="text-white"> | </span>
    <a href="{{ route('home') }}" class='active'>Início</a>
@endsection

@section('content')
    <div class="panel-body bg-light p30">
        <div class="row">
            <div class="col-sm-12 pr30">
                <div class="alert alert-danger alert-dismissable mb30">
                    <h3 class="mt5">Erro:</h3>
                    <p>SIstema não encontrado, ou você não tem permissão para acessá-lo!</p>
                </div>
            </div>
        </div>
    </div>
@endsection
