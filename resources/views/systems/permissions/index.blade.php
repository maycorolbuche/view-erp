@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')

    <x-content>

        <x-panel title="Formulário">

            @include('layouts.partials.messages')

            @if (isset($data) && $data->root == true)
                <blockquote class="blockquote-warning">
                    <p>Este é o sistema principal. Não é possível excluí-lo.</p>
                </blockquote>
            @endif

            <x-form action-name="systems" action-id="{{ isset($data) ? $data->id_system : null }}">
                <x-group>
                    <x-input name="name" width="400" label="Nome" required value="{{ $data->name ?? '' }}" />
                    <x-input type="icon" name="icon" width="100" label="Ícone" required
                        value="{{ $data->icon ?? '' }}" />
                    <x-input type="slug" name="slug" width="150" required label="Nome URL"
                        value="{{ $data->slug ?? '' }}" />
                </x-group>

                <x-group right>
                    <x-button type="store" hidden="{{ isset($data) }}" />
                    <x-button type="store-new" hidden="{{ !isset($data) }}" />
                    <x-button type="update" hidden="{{ !isset($data) }}" />
                    <x-button type="delete" hidden="{{ !isset($data) }}" disabled="{{ isset($data) && $data->root }}" />
                    <x-button type="cancel" route-name="systems" />
                </x-group>

            </x-form>
        </x-panel>

        <x-panel title="Dados">
            @include('systems.components.datatable', ['route' => 'systems.show'])
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
