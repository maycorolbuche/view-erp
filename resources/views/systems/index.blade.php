@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')

    <x-content>
        <x-panel title="Formulário">
            <x-form action-name="systems.store">
                <x-group>
                    <x-input width="100" label="Ates" disabled value="ddd" />
                    <x-input width=100 name="AAA" label="Teste" label="required" required="false" readonly />
                    <x-input id="BBB" label="required true" required="true" />
                    <x-input label="required false" required="false" />
                    <x-input label="R2" name="CCC" id="DDD" label="required str" required="dfsd" />
                    <x-input label="required 0" required=0 />
                    <x-input type="number" label="required 1" required="1" />
                    <x-input label="required 0" required="0" placeholder="ASDdd" value="fds" />
                </x-group>

                <x-group right>
                    <x-button type="store" />
                    <x-button type="store-new" />
                    <x-button type="update" />
                    <x-button type="delete" />
                    <x-button type="cancel" route-name="systems" />
                </x-group>

            </x-form>
        </x-panel>

        <x-panel title="Dados">
            <x-data-table data-origin="systems.datatable" />
        </x-panel>
    </x-content>

@endsection
