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

            <x-data-table id="expenses_query" data-origin="queries-expenses.datatable"
                query-string="route=queries-expenses.show" order="date" order-dir="desc"
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
                created-row="if (data['refundable'] !== 1) { $('td', row).addClass('danger'); }" searchable="no">

                <x-group title="Filtros de Busca">
                    <x-input type="date" name="start_date" width="150" label="Data Inicial"
                        value="{{ date('Y-m-01') }}" />
                    <x-input type="date" name="end_date" width="150" label="Data Final"
                        value="{{ date('Y-m-t') }}" />
                    <x-input type="number" name="id_batch" width="130" label="Lote" />

                    <x-input type="select" name="id_category" width="200" label="Tipo de Despesa"
                        list="{{ json_encode($categories) }}" list-value="id_category" list-text="name" />
                    <x-input type="select" name="id_payment_method" width="200" label="Tipo de Pagamento"
                        list="{{ json_encode($payment_methods) }}" list-value="id_payment_method" list-text="name" />
                    <x-input type="select" name="id_client" width="250" label="Cliente"
                        list="{{ json_encode($clients) }}" list-value="id_client" list-text="name" />
                    <x-input type="select" name="id_user" width="250" label="Usuário"
                        list="{{ json_encode($users) }}" list-value="id_user" list-text="name" />
                </x-group>

                <x-tabs>
                    <li data-id="tab-data" class="tab">
                        <a href="javascript:" onclick="dtQueryExpensesTab('tab-data')">
                            Dados
                        </a>
                    </li>
                    <li data-id="tab-simulator" class="tab">
                        <a href="javascript:" onclick="dtQueryExpensesTab('tab-simulator')">
                            Simulador
                        </a>
                    </li>
                </x-tabs>

                <div class="filter--ignore" data-id="simulator">
                    <div style="font-weight:bold;padding-bottom:15px;">Simule valores e médias de valores</div>

                    <div data-id="simulator-data">
                        <table class="table">
                            <thead>
                                <th>Item</th>
                                <th>Qtd. Recursos</th>
                                <th>Valor</th>
                                <th>Divisão</th>
                                <th>Média</th>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <th></th>
                                <th></th>
                                <th class="text-right total-amount"></th>
                                <th></th>
                                <th></th>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </x-data-table>
        </x-panel>
    </x-content>
@endsection

@push('scripts')
    <script>
        function dtQueryExpensesTab(id) {
            $("[data-table-filter='expenses_query']").find(".tab").removeClass("active");
            $("[data-table-filter='expenses_query']").find("[data-id=" + id + "]").addClass("active");

            $("[data-table-id='expenses_query']").hide();
            $("[data-id='simulator']").hide();
            if (id == "tab-data") {
                $("[data-table-id='expenses_query']").show();
            }
            if (id == "tab-simulator") {
                $("[data-id='simulator']").show();
            }
        }

        let currentRequest = null;

        function loadSimulator() {
            const $container = $("[data-table-filter='expenses_query'] [data-id='simulator']");
            const $container_data = $container.find("[data-id='simulator-data']");
            const $tbody = $container_data.find("tbody")


            $container_data.addClass("loading");

            let params = {};
            $("[data-table-filter='expenses_query']")
                .find('input, select')
                .each(function() {
                    params[$(this).attr('name')] = $(this).val();
                });


            // Se já tiver uma requisição em andamento, cancela
            if (currentRequest && currentRequest.readyState !== 4) {
                currentRequest.abort();
            }

            currentRequest = $.ajax({
                url: "{{ route('queries-expenses.datatable') }}",
                data: {
                    type: 'simulator',
                    ...params
                },
                success: function(data) {
                    $tbody.html(data)
                    $tbody.find("input, select").change(function() {
                        calcItemsSimulator();
                    });
                    calcItemsSimulator();
                    $container_data.removeClass("loading");
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if (textStatus === 'abort') return;

                    $tbody.html("")

                    new PNotify({
                        text: 'Ocorreu um erro ao carregar dados da simulação.',
                        type: 'danger',
                        delay: 1400
                    });
                    $container_data.removeClass("loading");
                },
            });
        }

        function calcItemsSimulator() {
            const $container = $("[data-table-filter='expenses_query'] [data-id='simulator']");
            const $container_data = $container.find("[data-id='simulator-data']");
            const $tbody = $container_data.find("tbody")
            const $tfoot = $container_data.find("tfoot")

            let total_amount = 0
            $tbody.find("tr").each(function() {
                const amount = $(this).find(".total-amount").find("input[type='hidden']").val();
                const division = $(this).find(".total-items").find("input").val();

                let avg;

                if (division == 0) {
                    avg = "-";
                } else {
                    avg = parseFloat(amount) / parseFloat(division);
                    if (isNaN(avg)) {
                        avg = 0;
                    }
                }

                const avg_br = avg.toLocaleString('pt-BR', {
                    style: 'currency',
                    currency: 'BRL'
                });
                $(this).find(".avg").html(avg_br);

                total_amount += parseFloat(amount) || 0;
            })

            const total_amount_br = total_amount.toLocaleString('pt-BR', {
                style: 'currency',
                currency: 'BRL'
            });
            $tfoot.find(".total-amount").html(total_amount_br);
        }
        $(document).ready(function() {
            $("[data-table-filter='expenses_query']")
                .find('input:not(.--filter-ignore):not([type=hidden]), select:not(.--filter-ignore)')
                .change(function() {
                    loadSimulator();
                });

            dtQueryExpensesTab('tab-data');
            loadSimulator();
        });
    </script>
@endpush

@push('styles')
    <style>
        [data-table-filter='expenses_query'] .loading {
            opacity: .5;
            pointer-events: none;
        }
    </style>
@endpush
