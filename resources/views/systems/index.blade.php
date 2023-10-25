@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')

    <x-content>

        <x-panel title="Formulário">

            @include('layouts.partials.messages')

            <x-form action-name="systems" action-id="{{ isset($data) ? $data->id_system : null }}">
                <x-group>
                    <x-input name="name" width="400" label="Nome" required value="{{ $data->name ?? '' }}" />
                    <x-input name="icon" width="100" label="Ícone" value="{{ $data->icon ?? '' }}" />
                    <x-input type="slug" name="slug" width="150" label="Nome URL"
                        value="{{ $data->slug ?? '' }}" />
                </x-group>

                <x-group right>
                    <x-button type="store" hidden="{{ isset($data) }}" />
                    <x-button type="store-new" hidden="{{ !isset($data) }}" />
                    <x-button type="update" hidden="{{ !isset($data) }}" />
                    <x-button type="delete" hidden="{{ !isset($data) }}" />
                    <x-button type="cancel" route-name="systems" />
                </x-group>

            </x-form>
        </x-panel>

        <x-panel title="Dados">
            <x-data-table data-origin="systems.datatable" order="name"
                columns="{{ json_encode([
                    [
                        'data' => 'actions',
                        'width' => '20px',
                        'orderable' => false,
                    ],
                    [
                        'title' => 'Código',
                        'data' => 'id_system',
                        'className' => 'text-right',
                    ],
                    [
                        'title' => 'Nome',
                        'data' => 'name',
                    ],
                ]) }}"
                created-row="if (data['root'] == 1) { $('td', row).addClass('warning'); }" />
        </x-panel>
    </x-content>
@endsection

@section('scripts')
    <script>
        $("[name=name]").blur(function() {
            if ($("[name=slug]").val() == "") {
                $("[name=slug]").val($("[name=name]").val()).blur()
            }
        });
    </script>
@endsection
