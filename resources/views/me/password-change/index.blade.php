@extends('layouts.app')
@section('title', 'Alterar Senha')
@section('breadcrumb', json_encode([['label' => 'Alterar Senha', 'icon' => 'fas fa-key']]))

@section('content')
    <x-content>

        <x-panel title="Alteração de Senha">

            @include('layouts.partials.messages')

            <x-form action-name="me-password-change" action="{{ route('me-password-change.update') }}">

                <x-group>
                    <x-input type="passworda" name="current_password" label="Senha Atual" required />
                </x-group>
                <x-group>
                    <x-input type="passworda" name="new_password" label="Nova Senha" required />
                    <x-input type="passworda" name="new_password_confirmation" label="Confirme a Nova Senha" required />
                </x-group>

                <x-group right>
                    <x-button type="update" />
                    <x-button type="cancel" route-name="me-authorizations" />
                </x-group>

            </x-form>
        </x-panel>

    </x-content>
@endsection
