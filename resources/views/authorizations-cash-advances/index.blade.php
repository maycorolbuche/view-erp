@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')
    <x-content>

        <x-panel title="Formulário" type="primary">

            @include('layouts.partials.messages')


            @if (count($authorizations) <= 0)
                <x-note type="danger">
                    Você não possui autorizações de despesa em aberto! Não será possível solicitar adiantamento.

                    <x-group right>
                        <a type="button" class="btn btn-info" href="{{ route('authorizations-expenses') }}">
                            Solicitar Autorização
                        </a>
                    </x-group>
                </x-note>
            @elseif (count($parents) <= 0)
                <x-note type="danger">
                    <p>
                        Não há nenhuma pessoa cadastrada para aprovar seu adiantamento!
                        <br>Entre em contato com o administrador do sistema.
                    </p>
                </x-note>
            @else
                <x-form action-name="authorizations-cash-advances" action-id="{{ null }}">
                    <x-group>
                        <x-input type="select" name="id_authorization_parent" width="400" label="Autorização de Despesa"
                            required list="{{ json_encode($authorizations) }}" list-value="id_authorization"
                            list-text="description_details" />
                        <x-input type="money" name="amount" width="150" label="Valor" required />
                        <x-input type="html" width="150" label="Saldo de Adiantamento">
                            <h2 style="margin: 0;margin-top: 7px;padding: 0;float: right;">
                                R$ {{ number_format($user_cash->amount ?? 0, 2, ',', '.') }}
                            </h2>
                        </x-input>
                    </x-group>
                    <x-group>
                        <x-input name="description" width="600" label="Motivo da Solicitação" required />
                    </x-group>
                    <x-group>
                        <div class="form-group" style="padding: 0 5px 0 5px;">
                            <label for="id_client" class="col-lg-3 control-label" style="padding:0;width:100%;">
                                Responsáveis pela Aprovação:
                            </label>
                            <div>
                                @foreach ($parents as $user)
                                    <div class="tm-tag tm-tag-primary" style="float:left;margin-bottom:5px;">
                                        <span>{{ $user['name'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </x-group>

                    <x-note type="warning">
                        Confira os dados antes enviar a solicitação! Os mesmos não poderão ser alterados após o envio.
                    </x-note>

                    <x-group right>
                        <x-button type="store" permission="{{ in_array('store', request('__permissions_page')) }}" />
                        <x-button type="cancel" route-name="authorizations-cash-advances" />
                    </x-group>

                </x-form>

            @endif
        </x-panel>

        <x-panel title="Dados" type="warning">
            @include('authorizations-cash-advances.components.datatable', [
                'route' => 'me-authorizations.show',
            ])
        </x-panel>
    </x-content>
@endsection
