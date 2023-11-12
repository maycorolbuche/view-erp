@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')
    <x-content>

        <x-panel title="Formulário" type="primary">

            @include('roles.components.header', ['role' => isset($data) ? $data : null])

            @include('layouts.partials.messages')

            <x-form action-name="roles" action-id="{{ isset($data) ? $data->id_role : null }}">
                <x-group>
                    <x-input name="name" width="400" label="Nome" required value="{{ $data->name ?? '' }}" />
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
                    <x-button type="cancel" route-name="roles" />
                </x-group>

            </x-form>
        </x-panel>

        <x-panel title="Dados" type="warning">
            @include('roles.components.datatable', ['route' => 'roles.show'])
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
