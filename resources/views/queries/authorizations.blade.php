@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')
    <x-content>

        @if (isset($data))

            @php
                $type = 'muted';
                $status = 'Expirado';
                if ($data->approved === 1) {
                    $type = 'success';
                    $status = 'Aprovado';
                } elseif ($data->approved === 0) {
                    $type = 'danger';
                    $status = 'Negado';
                } elseif ($data->active === 1) {
                    $type = 'warning';
                    $status = 'Pendente';
                }
            @endphp

            <x-panel title="Detalhes da Autorização | {{ $status }}" type="{{ $type }}">

                @include('layouts.partials.messages')

                <span class='badge badge-success'>{{ $data->authorization_type->name }}</span>
                <span class='badge badge-{{ $type }}'>{{ $status }}</span>
                <h1 class="mtn" style="margin:0;margin-top:10px;">
                    <small>
                        {{ $data->user->name ?? '' }}
                    </small>
                </h1>

                <h2 style="margin:0">
                    <small>
                        @if ($data->authorization_type->type == 'expense')
                            {{ $data->start_date_br }} a {{ $data->end_date_br }}
                        @elseif ($data->authorization_type->type == 'cash-advance' || $data->authorization_type->type == 'cash-advance-return')
                            {{ $data->start_date_br }}
                            <br>Valor: R$ {{ number_format(abs($data->amount), 2, ',', '.') }}

                            @if ($data->authorization_type->type == 'cash-advance')
                                <br>Autorização vinculada: {{ $data->authorization_parent->description_details ?? '' }}
                            @endif
                        @endif
                    </small>
                </h2>

                <br>

                @if (trim($data->description) != '')
                    <x-note>
                        {{ $data->description }}
                    </x-note>
                @endif

                @if ($data->authorization_type->type == 'expense')
                    <div class="panel-heading">
                        <span class="panel-title">
                            <span>Clientes</span>
                        </span>
                    </div>

                    <div class="panel-body pn">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tbody>
                                    @foreach ($data->clients as $client)
                                        <tr>
                                            <td>{{ $client->name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                <br>

                <div class="panel-heading">
                    <span class="panel-title">
                        <span>Autorizações</span>
                    </span>
                </div>
                <div class="panel-body pn">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>E-mail</th>
                                    <th>Status</th>
                                    <th>Motivo (caso recusado)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data->statuses as $user)
                                    @php
                                        $user_type = 'muted';
                                        $user_status = 'Não informado';
                                        if ($user->pivot->approved === 1) {
                                            $user_type = 'success';
                                            $user_status = 'Aprovado';
                                        } elseif ($user->pivot->approved === 0) {
                                            $user_type = 'danger';
                                            $user_status = 'Negado';
                                        } elseif ($data->approved === null && $data->active === 1) {
                                            $user_type = 'warning';
                                            $user_status = 'Pendente';
                                        }
                                    @endphp
                                    <tr class="{{ $user_type }}">
                                        <td>{{ $user->short_name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user_status }}</td>
                                        <td>{{ $user->pivot->description }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <br>

                <x-group right>
                    <x-button type="cancel" route-name="queries-authorizations" />
                </x-group>

            </x-panel>
        @endif

        <x-panel title="Dados" type="warning">
            <x-data-table data-origin="queries-authorizations.datatable" query-string="route=queries-authorizations.show"
                order="id_authorization" order-dir="desc"
                columns="{{ json_encode([
                    [
                        'data' => 'actions_search',
                        'width' => '20px',
                        'orderable' => false,
                    ],
                    [
                        'title' => 'Código',
                        'data' => 'id_authorization',
                        'className' => 'text-right',
                    ],
                    [
                        'title' => 'Nome',
                        'data' => 'user.name',
                    ],
                    [
                        'title' => 'Tipo',
                        'data' => 'authorization_type.name',
                    ],
                    [
                        'title' => 'Período',
                        'data' => 'period',
                        'className' => 'text-center',
                        'orderable' => false,
                    ],
                    [
                        'title' => 'Descrição',
                        'data' => 'description',
                    ],
                    [
                        'title' => 'Clientes',
                        'data' => 'clients',
                        'orderable' => false,
                    ],
                    [
                        'title' => 'Autorizações',
                        'data' => 'statuses',
                        'orderable' => false,
                    ],
                    [
                        'title' => 'Status',
                        'data' => 'approved',
                    ],
                ]) }}" />
        </x-panel>
    </x-content>
@endsection
