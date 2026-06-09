@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')

    <x-content>

        <x-panel title="Formulário">

            @include('users.components.header', compact('user'))

            @include('users.components.tabs', ['id' => $pid])

            @include('layouts.partials.messages')

            <x-form action-name="users-admission" action="{{ route('users-admission.update', compact('pid')) }}">
                <x-group>
                    <x-input type="date" name="hire_date" width="150" label="Data de Início"
                        value="{{ $user->hire_date ?? '' }}" />
                    <x-input type="date" name="termination_date" width="150" label="Data de Saída"
                        value="{{ $user->termination_date ?? '' }}" />
                </x-group>
                <x-group>
                    <x-input type="textarea" name="admission_notes" width="400" label="Anotações/Observações"
                        value="{{ $user->admission_notes ?? '' }}" />
                </x-group>

                <x-group right>
                    <x-button type="update" permission="{{ in_array('update', request('__permissions_page')) }}" />
                    <x-button type="cancel" route-name="users-admission" />
                </x-group>
            </x-form>

        </x-panel>

        <x-panel title="Dados">
            @include('users.components.datatable', [
                'route' => 'users-admission.index',
                'field' => 'pid',
            ])
        </x-panel>
    </x-content>
@endsection
