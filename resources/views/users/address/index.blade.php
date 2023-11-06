@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')

    <x-content>

        <x-panel title="Formulário" type="primary">

            @include('users.components.header', compact('user'))

            @include('users.components.tabs', ['id' => $pid])

            @include('layouts.partials.messages')

            @if ($user->root == true)
                <blockquote class="blockquote-warning">
                    <p>Este é um perfil do sistema.</p>
                </blockquote>
            @endif

            <x-form action-name="users-address" action="{{ route('users-address.update', compact('pid')) }}">
                <x-group>
                    <x-input type="zip_code" name="zip_code" width="150" label="CEP" value="{{ $user->zip_code ?? '' }}" />
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

        <x-panel title="Dados" type="warning">
            @include('users.components.datatable', [
                'route' => 'users-address.index',
                'field' => 'pid',
            ])
        </x-panel>
    </x-content>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#zip_code').on('focus', function() {
                    $(this).data('cep', $(this).val());
                });
                $('#zip_code').on('blur', function() {
                    const old_cep = $(this).data('cep');
                    const cep = $(this).val().replace(/[^0-9]+/g, '');
                    const url = `https://viacep.com.br/ws/${cep}/json/`;

                    if (old_cep == $(this).val()) {
                        return false;
                    }

                    if (cep.length >= 8) {
                        loading();
                        $.ajax({
                            url: url,
                            dataType: 'json',
                            success: function(data) {
                                loading(false);
                                console.log(data);
                                if (data.logradouro) {
                                    $('#address').val(data.logradouro);
                                    $('#district').val(data.bairro);
                                    $('#city').val(data.localidade);
                                    $('#state').val(data.uf);
                                } else if (data.erro) {
                                    new PNotify({
                                        text: 'CEP não encontrado!',
                                        type: 'danger',
                                        delay: 1400
                                    });
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                loading(false);
                                new PNotify({
                                    text: 'Ocorreu um erro ao buscar o CEP.',
                                    type: 'danger',
                                    delay: 1400
                                });
                            }
                        });
                    }
                });
            });
        </script>
    @endpush
@endsection
