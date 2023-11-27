@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')
    <x-content>

        <x-panel title="Formulário" type="primary">

            @include('layouts.partials.messages')

            @if (count($parents) <= 0)
                <blockquote class="blockquote-danger">
                    <p>
                        Não há nenhuma pessoa cadastrada para aprovar suas despesas!
                        <br>Entre em contato com o administrador do sistema.
                    </p>
                </blockquote>
            @else
                <x-form action-name="authorizations-expenses" action-id="{{ null }}">
                    <x-group>
                        <x-input type="date" name="start_date" width="150" label="Data Inicial" required />
                        <x-input type="date" name="end_date" width="150" label="Data Final" required />
                    </x-group>
                    <x-group>
                        <x-input name="description" width="600" label="Motivo da Solicitação" required />
                    </x-group>
                    <x-group>
                        <x-input type="multiple" name="id_client" width="200" label="Clientes Envolvidos"
                            list="{{ json_encode($clients) }}" list-value="id_client" list-text="name" required />
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

                    <x-group right>
                        <x-button type="store" permission="{{ in_array('store', request('__permissions_page')) }}" />
                        <x-button type="cancel" route-name="authorizations-expenses" />
                    </x-group>

                </x-form>

            @endif
        </x-panel>

        <x-panel title="Dados" type="warning">
            @include('authorizations-expenses.components.datatable', [
                'route' => 'me-authorizations.show',
            ])
        </x-panel>
    </x-content>
@endsection
