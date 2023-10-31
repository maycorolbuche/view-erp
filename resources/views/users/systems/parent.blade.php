@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')

    <x-content>
        <x-panel title="Dados">
            @include('users.components.tabs')

            @include('layouts.partials.messages')

            @include('users.components.datatable', [
                'route' => 'users-systems.index',
                'field' => 'pid',
            ])
        </x-panel>
    </x-content>

@endsection
