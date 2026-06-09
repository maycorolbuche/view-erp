@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')

    <x-content>

        <x-panel title="Formulário">

            @include('users.components.header', compact('user'))

            @include('users.components.tabs', ['id' => $pid])

            @include('layouts.partials.messages')

            <x-form action-name="users-discounts" action="{{ route('users-discounts.update', compact('pid')) }}">
                <x-group>
                    <x-input type="multiple" name="id_discount" width="250" label="Tipos de Despesa"
                        list="{{ json_encode($discounts) }}" list-value="id_discount" list-text="name"
                        value="{{ json_encode($user->id_discount ?? []) }}" />
                </x-group>

                <x-group right>
                    <x-button type="update" permission="{{ in_array('update', request('__permissions_page')) }}" />
                    <x-button type="cancel" route-name="users-discounts" />
                </x-group>
            </x-form>

        </x-panel>

        <x-panel title="Dados">
            @include('users.components.datatable', [
                'route' => 'users-discounts.index',
                'field' => 'pid',
            ])
        </x-panel>
    </x-content>
@endsection
