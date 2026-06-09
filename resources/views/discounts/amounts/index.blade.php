@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')

    <x-content>

        <x-panel title="Formulário">

            @include('discounts.components.header', compact('discount'))

            @include('discounts.components.tabs', ['id' => $pid])

            @include('layouts.partials.messages')

            <x-form action-name="discounts-amounts" action-id="{{ isset($data) ? $data->id_discount_amount : null }}"
                action-pid="{{ $pid }}">
                <x-group>
                    <x-input type="date" name="date" width="150" label="Data" required
                        value="{{ $data->date ?? '' }}" />
                    <x-input type="money" name="amount" width="200" label="Valor" required
                        value="{{ $data->amount ?? '' }}" />
                </x-group>

                <x-group right>
                    <x-button type="store" hidden="{{ isset($data) }}"
                        permission="{{ in_array('store', request('__permissions_page')) }}" />
                    <x-button type="store-new" hidden="{{ !isset($data) }}"
                        permission="{{ in_array('store', request('__permissions_page')) }}" />
                    <x-button type="update" hidden="{{ !isset($data) }}"
                        permission="{{ in_array('update', request('__permissions_page')) }}" />
                    <x-button type="delete" hidden="{{ !isset($data) }}"
                        permission="{{ in_array('destroy', request('__permissions_page')) }}" />
                    @if (isset($data))
                        <x-button type="cancel" route="{{ route('discounts-amounts.index', ['pid' => $pid]) }}" />
                    @else
                        <x-button type="cancel" route-name="discounts-amounts" />
                    @endif
                </x-group>

            </x-form>

            <br>

            <x-panel title="Lista de Valores">
                <x-data-table data-origin="discounts-amounts.datatable" pid={{ $pid }}
                    query-string="pid={{ $pid }}" order="date" order-dir="desc"
                    columns="{{ json_encode([
                        [
                            'data' => 'actions',
                            'width' => '20px',
                            'orderable' => false,
                        ],
                        [
                            'title' => 'Código',
                            'data' => 'id_discount_amount',
                            'className' => 'text-right',
                        ],
                        [
                            'title' => 'Data',
                            'data' => 'date',
                            'className' => 'text-center',
                        ],
                        [
                            'title' => 'Valor',
                            'data' => 'amount',
                            'className' => 'text-right',
                        ],
                    ]) }}" />

            </x-panel>

        </x-panel>

        <x-panel title="Dados">
            @include('discounts.components.datatable', [
                'route' => 'discounts-amounts.index',
                'field' => 'pid',
            ])
        </x-panel>
    </x-content>
@endsection
