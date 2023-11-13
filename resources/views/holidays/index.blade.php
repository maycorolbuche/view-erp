@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')
    <x-content>

        <x-panel title="Formulário" type="primary">

            @include('holidays.components.header', ['holiday' => isset($data) ? $data : null])

            @include('layouts.partials.messages')

            <x-form action-name="holidays" action-id="{{ isset($data) ? $data->id_holiday : null }}">
                <x-group>
                    <x-input name="name" width="400" label="Nome" required value="{{ $data->name ?? '' }}" />
                    <x-input type="date" name="date" width="150" label="Data" required
                        value="{{ $data->date ?? '' }}" />
                    <x-input type="bool" name="repeat" width="200" label="Recorrente?"
                        value="{{ $data->repeat ?? '' }}" tip="Marque se o feriado se repete todo ano na mesma data" />
                </x-group>
                <x-group>
                    @php
                        $idBranchValues = [];
                        if (isset($data) && isset($data->holidays_branches)) {
                            foreach ($data->holidays_branches as $item) {
                                $idBranchValues[] = $item['id_branch'];
                            }
                        }
                    @endphp

                    <x-input type="checkbox" name="id_branch" width="200" label="Filiais"
                        list="{{ json_encode($branches) }}" list-value="id_branch" list-text="name"
                        value="{{ json_encode($idBranchValues ?? '[]') }}" tip="Se for feriado nacional, deixe em branco" />
                </x-group>

                <x-group right>
                    <x-button type="store" hidden="{{ isset($data) }}"
                        permission="{{ in_array('store', request('__permissions_page')) }}" />
                    <x-button type="store-new" hidden="{{ !isset($data) }}"
                        permission="{{ in_array('store', request('__permissions_page')) }}" />
                    <x-button type="update" hidden="{{ !isset($data) }}"
                        permission="{{ in_array('update', request('__permissions_page')) }}" />
                    <x-button type="delete" hidden="{{ !isset($data) }}" disabled="{{ isset($data) && $data->root }}"
                        permission="{{ in_array('destroy', request('__permissions_page')) }}" />
                    <x-button type="cancel" route-name="holidays" />
                </x-group>

            </x-form>
        </x-panel>

        <x-panel title="Dados" type="warning">
            @include('holidays.components.datatable', ['route' => 'holidays.show'])
        </x-panel>
    </x-content>
@endsection
