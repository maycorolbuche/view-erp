@extends('layouts.auth')

@section('width', 800)

@section('header-links')
    <a href="{{ route('logout') }}">Desconectar</a>
@endsection

@section('content')
    <div id="topbar-dropmenu" class="topbar-menu-open" style="display: block;">
        <div class="row ml5 mb5">
            <div class="col-12">
                <span class="text-white">Olá, {{ auth()->user()->name }}</span>
            </div>
            <div class="col-12">
                <span class="text-white text-bold">Escolha o Sistema:</span>
            </div>
        </div>
        <div class="topbar-menu row">
            @foreach ($systems as $system)
                <div class="col-xs-6 col-sm-3">
                    <a href="{{ route('system.' . $system['slug']) }}"
                        class="metro-tile bg-success animated animated-short fadeInDown" style="opacity: 1;">
                        <span class="metro-icon {{ $system['icon'] }}"></span>
                        <p class="metro-title">{{ $system['name'] }}</p>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

@endsection
