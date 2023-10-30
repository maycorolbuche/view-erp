@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')

    <x-content>
        <x-panel title="Dados">
            @include('systems.components.tabs')

            @include('systems.components.datatable', [
                'route' => 'systems-permissions.index',
                'field' => 'pid',
            ])
        </x-panel>
    </x-content>

@endsection
