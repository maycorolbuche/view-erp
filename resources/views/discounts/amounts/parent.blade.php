@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')

    <x-content>
        <x-panel title="Dados">
            @include('discounts.components.tabs')

            @include('layouts.partials.messages')

            @include('discounts.components.datatable', [
                'route' => 'discounts-amounts.index',
                'field' => 'pid',
            ])
        </x-panel>
    </x-content>

@endsection
