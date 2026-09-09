@extends('layouts.auth')

@section('header-links')
    <form action="{{ route('logout') }}" method="POST" class="d-inline">
        @csrf
        <button type="submit" class="btn btn-link p-0 text-white">Desconectar</button>
    </form>
    <span class="text-white"> | </span>
    <a href="{{ route('home') }}" class='active'>Início</a>
@endsection

@section('content')
    <div class="panel-body bg-light p30">
        <div class="row">
            <div class="col-sm-12 pr30">
                <div class="alert alert-danger alert-dismissable mb30">
                    <h3 class="mt5">Erro:</h3>
                    <p>Não foi possível localizar este documento!</p>
                </div>
            </div>
        </div>
    </div>
@endsection
