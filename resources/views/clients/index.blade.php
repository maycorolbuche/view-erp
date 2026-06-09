@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')
    <x-content>

        <x-panel title="Formulário">

            @include('clients.components.header', ['client' => isset($data) ? $data : null])

            @include('layouts.partials.messages')

            <x-form action-name="clients" action-id="{{ isset($data) ? $data->id_client : null }}">
                <x-group>
                    <x-input name="name" width="400" label="Nome" required value="{{ $data->name ?? '' }}" />
                    <x-input name="short_name" width="100" label="Nome Abreviado" required
                        value="{{ $data->short_name ?? '' }}" />
                </x-group>

                <x-group title="Endereço">
                    <x-input type="zip_code" name="zip_code" width="150" label="CEP"
                        value="{{ $data->zip_code ?? '' }}" />
                    <x-input type="text" name="address" width="400" label="Endereço"
                        value="{{ $data->address ?? '' }}" />
                    <x-input type="text" name="number" width="150" label="Nº"
                        value="{{ $data->number ?? '' }}" />
                    <x-input type="text" name="complement" width="400" label="Complemento"
                        value="{{ $data->complement ?? '' }}" />
                    <x-input type="text" name="district" width="300" label="Bairro"
                        value="{{ $data->district ?? '' }}" />
                    <x-input type="text" name="city" width="300" label="Cidade" value="{{ $data->city ?? '' }}" />
                    <x-input type="text" name="state" width="180" label="Estado" value="{{ $data->state ?? '' }}" />
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
                    <x-button type="cancel" route-name="clients" />
                </x-group>

            </x-form>
        </x-panel>

        <x-panel title="Dados">
            @include('clients.components.datatable', ['route' => 'clients.show'])
        </x-panel>
    </x-content>
@endsection


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
