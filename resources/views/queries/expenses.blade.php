@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')
    <x-content>

        @if (isset($data))
            <x-panel title="Formulário" type="primary">

                @include('layouts.partials.messages')

                {!! $data->payment_method->refundable
                    ? "<span class='badge badge-info'>Reembolsável</span>"
                    : "<span class='badge badge-danger'>Não Reembolsável</span>" !!}
                <h1 class="mtn" style="margin:0;margin-top:10px;">
                    <small>
                        {{ $data->user->name ?? '' }}
                    </small>
                </h1>

                <br>

                <x-group>
                    <x-input type="html" width="200" label="Autorização"
                        value="{{ $data->authorization->description_details }}" />
                </x-group>

                <x-group>
                    <x-input type="html" width="100" label="Data"
                        value="{{ \Carbon\Carbon::parse($data->date)->format('d/m/Y') }}" />
                    <x-input type="html" width="200" label="Tipo de Despesa"
                        value="{{ $data->category->name ?? '' }}" />
                    <x-input type="html" width="100" label="Valor"
                        value="R$ {{ number_format($data->amount ?? 0, 2, ',', '.') }}" />
                    <x-input type="html" width="200" label="Tipo de Pagamento"
                        value="{{ $data->payment_method->name ?? '' }}" />
                    <x-input type="html" width="50" label="Lote" value="{{ $data->id_batch ?? '' }}" />
                </x-group>

                <div class="panel-heading">
                    <span class="panel-title">
                        <span>Distribuição do valor da despesa por cliente:</span>
                    </span>
                </div>
                <div class="panel-body pn">
                    <div class="table-responsive">
                        <table class="table table-hover table-clients">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th class="text-right">%</th>
                                    <th class="text-right">Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data->clients as $client)
                                    <tr>
                                        <td>
                                            {{ $client['name'] }}
                                        </td>
                                        <td class="text-right">
                                            {{ number_format($client['pivot']['percentage'] ?? 0, 2, ',', '.') }}
                                        </td>
                                        <td class="text-right">
                                            {{ number_format($client['pivot']['amount'] ?? 0, 2, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>


                <div class="panel-heading">
                    <span class="panel-title">
                        <span>Recursos da despesa:</span>
                    </span>
                </div>
                <div class="panel-body pn">
                    <div class="table-responsive">
                        <table class="table table-hover table-users">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th class="text-right">%</th>
                                    <th class="text-right">Valor</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data->users as $user)
                                    <tr>
                                        <td>
                                            {{ $user['name'] }}
                                        </td>
                                        <td class="text-right">
                                            {{ number_format($user['pivot']['percentage'] ?? 0, 2, ',', '.') }}
                                        </td>
                                        <td class="text-right">
                                            {{ number_format($user['pivot']['amount'] ?? 0, 2, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>

                <x-group>
                    <x-input type="html" width="500" label="Anotações / Observações"
                        value="{{ $data->notes ?? '' }}" />
                </x-group>


                <x-group right>
                    <x-button type="cancel" route-name="queries-expenses" />
                </x-group>

            </x-panel>
        @endif

        <x-panel title="Dados" type="warning">
            <x-data-table data-origin="queries-expenses.datatable" query-string="route=queries-expenses.show" order="date"
                order-dir="desc"
                columns="{{ json_encode([
                    [
                        'data' => 'actions_search',
                        'width' => '20px',
                        'orderable' => false,
                    ],
                    [
                        'title' => 'Código',
                        'data' => 'id_expense',
                        'className' => 'text-right',
                    ],
                    [
                        'title' => 'Data',
                        'data' => 'date',
                        'className' => 'text-center',
                    ],
                    [
                        'title' => 'Nome',
                        'data' => 'user.name',
                    ],
                    [
                        'title' => 'Tipo de Despesa',
                        'data' => 'category.short_name',
                    ],
                    [
                        'title' => 'Clientes',
                        'data' => 'clients',
                        'orderable' => false,
                    ],
                    [
                        'title' => 'Tipo de Pagamento',
                        'data' => 'payment_method.name',
                    ],
                    [
                        'title' => 'Valor',
                        'data' => 'amount',
                        'className' => 'text-right',
                    ],
                    [
                        'title' => 'Reembolsável?',
                        'data' => 'payment_method.refundable',
                        'className' => 'text-center',
                    ],
                    [
                        'title' => 'Lote',
                        'data' => 'id_batch',
                        'className' => 'text-right',
                    ],
                    [
                        'title' => 'Status Lote',
                        'data' => 'batch_status',
                        'className' => 'text-center',
                    ],
                ]) }}"
                created-row="if (data['refundable'] !== 1) { $('td', row).addClass('danger'); }">

                <x-group title="Filtros de Busca">
                    <x-input type="date" name="start_date" width="150" label="Data Inicial" />
                    <x-input type="date" name="end_date" width="150" label="Data Final" />
                    <x-input type="number" name="id_batch" width="130" label="Lote" />

                    <x-input type="select" name="id_category" width="200" label="Tipo de Despesa"
                        list="{{ json_encode($categories) }}" list-value="id_category" list-text="name" />
                    <x-input type="select" name="id_payment_method" width="200" label="Tipo de Pagamento"
                        list="{{ json_encode($payment_methods) }}" list-value="id_payment_method" list-text="name" />
                    <x-input type="select" name="id_client" width="250" label="Cliente"
                        list="{{ json_encode($clients) }}" list-value="id_client" list-text="name" />
                    <x-input type="select" name="id_user" width="250" label="Usuário" list="{{ json_encode($users) }}"
                        list-value="id_user" list-text="name" />
                </x-group>

            </x-data-table>
        </x-panel>
    </x-content>
@endsection
