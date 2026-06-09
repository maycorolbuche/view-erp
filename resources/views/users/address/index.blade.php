@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')

    <x-content>

        <x-panel title="Formulário">

            @include('users.components.header', compact('user'))

            @include('users.components.tabs', ['id' => $pid])

            @include('layouts.partials.messages')

            <x-form action-name="users-address" action="{{ route('users-address.update', compact('pid')) }}">
                <x-group>
                    <x-input type="zipcode" name="zip_code" width="150" label="CEP" address="address" district="district"
                        state="state" city="city" value="{{ $user->zip_code ?? '' }}" />
                    <x-input type="text" name="address" width="400" label="Endereço"
                        value="{{ $user->address ?? '' }}" />
                    <x-input type="text" name="number" width="150" label="Nº"
                        value="{{ $user->number ?? '' }}" />
                    <x-input type="text" name="complement" width="400" label="Complemento"
                        value="{{ $user->complement ?? '' }}" />
                    <x-input type="text" name="district" width="300" label="Bairro"
                        value="{{ $user->district ?? '' }}" />
                    <x-input type="text" name="city" width="300" label="Cidade" value="{{ $user->city ?? '' }}" />
                    <x-input type="text" name="state" width="180" label="Estado" value="{{ $user->state ?? '' }}" />
                </x-group>

                <x-group right>
                    <x-button type="update" permission="{{ in_array('update', request('__permissions_page')) }}" />
                    <x-button type="cancel" route-name="users-address" />
                </x-group>
            </x-form>

        </x-panel>

        <x-panel title="Dados">
            @include('users.components.datatable', [
                'route' => 'users-address.index',
                'field' => 'pid',
            ])
        </x-panel>
    </x-content>
@endsection
