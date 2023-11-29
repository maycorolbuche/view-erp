@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')
    <x-content>

        <x-panel title="Formulário" type="primary">

            @include('layouts.partials.messages')

            @if (!isset($data) && count($authorizations) <= 0)
                <blockquote class="blockquote-danger">
                    <p>
                        Você não possui autorizações de despesa em aberto! Não será possível cadastrar despesas.
                    </p>

                    <x-group right>
                        <a type="button" class="btn btn-info" href="{{ route('authorizations-expenses') }}">
                            Solicitar Autorização
                        </a>
                    </x-group>
                </blockquote>
            @else
                <x-form action-name="expenses" action-id="{{ isset($data) ? $data->id_expense : null }}">
                    <x-group>
                        @if (isset($data))
                            <x-input width="200" label="Autorização" readonly
                                value="{{ $data->authorization->description_details }}" />
                            <input type="hidden" name="id_authorization" value="{{ $data->id_authorization }}">
                        @else
                            @php
                                if (old('id_authorization')) {
                                    $id_authorization = old('id_authorization');
                                } elseif (count($authorizations) == 1) {
                                    $id_authorization = $authorizations[0]->id_authorization;
                                }
                            @endphp
                            <x-input type="select" name="id_authorization" width="200" label="Autorização" required
                                list="{{ json_encode($authorizations) }}" list-value="id_authorization"
                                list-text="description_details"
                                value="{{ $data->id_authorization ?? ($id_authorization ?? '') }}" />
                        @endif
                    </x-group>

                    <x-group>
                        <x-input type="date" name="date" width="150" label="Data" required
                            value="{{ $data->date ?? (date('Y-m-d') ?? '') }}" />
                        <x-input type="select" name="id_category" width="250" label="Tipo de Despesa" required
                            list="{{ json_encode($categories) }}" list-value="id_category" list-text="name"
                            value="{{ $data->id_category ?? '' }}" />
                        <x-input type="money" name="amount" width="150" label="Valor" required
                            value="{{ $data->amount ?? '' }}" />
                        <x-input type="select" name="id_payment_method" width="250" label="Tipo de Pagamento" required
                            list="{{ json_encode($payment_methods) }}" list-value="id_payment_method" list-text="name"
                            value="{{ $data->id_payment_method ?? '' }}" />

                        @if (!isset($data))
                            <x-input type="html" label="Distribuir" width="80">
                                <a href="javascript:" class="btn btn-info" id="bt_distribute" style="width: 100%"
                                    onclick="open_popup_distribute()">
                                </a>
                            </x-input>

                            <input type="hidden" name="distribute" id="distribute" value="{{ old('distribute') ?? 1 }}">

                            <div style="display:none;">
                                <div id="modal-content_distribute" class="popup-basic bg-none mfp-with-anim">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <span class="panel-title">Distribuição do valor</span>
                                        </div>
                                        <div class="panel-body">
                                            <x-group>
                                                <x-input type="number" name="_distribute" width="250" label="Qtd. dias"
                                                    value="1" min="1" max="50" />
                                            </x-group>
                                            <b>Observação:</b>
                                            <ul>
                                                <li>O valor será distribuído proporcionalmente pela quantidade de dias
                                                    informado;</li>
                                                <li>A data informada será a base inicial para distribuição do valor;</li>
                                                <li>Se a quantidade de dias ultrapassar a data final da autorização, no
                                                    último dia, será acumulado o restante do saldo do valor informado;</li>
                                                <li>Somente será distribuído para dias úteis;</li>
                                            </ul>
                                        </div>
                                        <div class="panel-footer text-right">
                                            <a class="btn btn-info" onclick="save_distribute()">Confirmar</a>
                                            <a class="btn btn-warning"
                                                onclick="$('#modal-content_distribute .mfp-close').click()">Cancelar</a>
                                        </div>
                                    </div>
                                    <button type="button" class="mfp-close">×</button>
                                </div>
                            </div>


                            @push('scripts')
                                <script>
                                    function open_popup_distribute() {
                                        $("#_distribute").val($("#distribute").val());

                                        $.magnificPopup.open({
                                            removalDelay: 500,
                                            mainClass: 'mfp-fade',
                                            items: {
                                                src: "#modal-content_distribute"
                                            },
                                            midClick: true
                                        });
                                    }

                                    function save_distribute() {
                                        $("#distribute").val($("#_distribute").val());
                                        button_distribute();
                                        $('#modal-content_distribute .mfp-close').click();
                                    }

                                    function button_distribute() {
                                        $("#bt_distribute").html(`Distribuir: ${$("#distribute").val()}`);
                                    }

                                    $(document).ready(function() {
                                        button_distribute();
                                    });
                                </script>
                            @endpush
                        @endif
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
                                    @foreach ($clients as $client)
                                        <tr class="data"
                                            style="{{ isset($data->clients[$client->id_client]) || (old('client_amount')[$client->id_client] ?? 0) > 0 ? '' : 'display:none;' }}"
                                            data-id="{{ $client->id_client }}">
                                            <td>
                                                {{ $client->name }}
                                            </td>
                                            <td class="client_percentage">
                                                <x-input type="number" name="client_percentage[{{ $client->id_client }}]"
                                                    value="{{ $data->clients[$client->id_client]['pivot']['percentage'] ?? '' }}"
                                                    min="0"
                                                    onchange="calc_amount('client_amount','client_percentage',{{ $client->id_client }})" />
                                            </td>
                                            <td class="client_amount">
                                                <x-input type="money" name="client_amount[{{ $client->id_client }}]"
                                                    value="{{ $data->clients[$client->id_client]['pivot']['amount'] ?? '' }}"
                                                    onchange="calc_percent('client_amount','client_percentage',{{ $client->id_client }})" />
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td class="client_percentage_total text-right text-bold"></td>
                                        <td class="client_amount_total text-right text-bold"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <br>

                    <div class="panel-heading">
                        <span class="panel-title">
                            <span>Recursos adicionais:</span>
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
                                    @foreach ($users as $user)
                                        <tr class="data"
                                            style="{{ isset($data->users[$user->id_user]) || (old('user_amount')[$user->id_user] ?? 0) > 0 ? '' : 'display:none;' }}"
                                            data-id="{{ $user->id_user }}">
                                            <td>
                                                {{ $user->name }}
                                            </td>
                                            <td class="user_percentage">
                                                <x-input type="number" name="user_percentage[{{ $user->id_user }}]"
                                                    value="{{ $data->users[$user->id_user]['pivot']['percentage'] ?? '' }}"
                                                    min="0"
                                                    onchange="calc_amount('user_amount','user_percentage',{{ $user->id_user }})" />
                                            </td>
                                            <td class="user_amount">
                                                <x-input type="money" name="user_amount[{{ $user->id_user }}]"
                                                    value="{{ $data->users[$user->id_user]['pivot']['amount'] ?? '' }}"
                                                    onchange="calc_percent('user_amount','user_percentage',{{ $user->id_user }})" />
                                            </td>
                                            <td class="text-right" style="width: 50px;">
                                                @if ($user->id_user != auth()->user()->id_user)
                                                    <a class="btn btn-danger" href="javascript:"
                                                        onclick="del_user({{ $user->id_user }})">
                                                        <i class="far fa-trash-alt"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>
                                            <x-input type="select" name="add_user" list="{{ json_encode($users) }}"
                                                list-value="id_user" list-text="name" />
                                        </td>
                                        <td class="user_percentage_total text-right text-bold"></td>
                                        <td class="user_amount_total text-right text-bold"></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <br>

                    <x-group>
                        <x-input type="textarea" name="notes" width="500" label="Anotações / Observações"
                            value="{{ $data->notes ?? '' }}" />
                    </x-group>

                    <x-group right>
                        <x-button type="store" hidden="{{ isset($data) }}"
                            permission="{{ in_array('store', request('__permissions_page')) }}" />
                        <x-button type="update" hidden="{{ !isset($data) }}"
                            permission="{{ in_array('update', request('__permissions_page')) }}" />
                        <x-button type="delete" hidden="{{ !isset($data) }}"
                            disabled="{{ isset($data) && $data->root }}"
                            permission="{{ in_array('destroy', request('__permissions_page')) }}" />
                        <x-button type="cancel" route-name="expenses" />
                    </x-group>

                </x-form>
            @endif
        </x-panel>

        <x-panel title="Dados" type="warning">
            @include('expenses.components.datatable', ['route' => 'expenses.show'])
        </x-panel>
    </x-content>
@endsection

@push('scripts')
    <script>
        var authorizations_clients = {};
        var date_range = {};
        @foreach ($authorizations as $authorization)
            authorizations_clients[{{ $authorization->id_authorization }}] = [];
            @foreach ($authorization->clients as $client)
                authorizations_clients[{{ $authorization->id_authorization }}].push({{ $client->id_client }});
            @endforeach
            date_range[{{ $authorization->id_authorization }}] = [
                '{{ $authorization->start_date }}', '{{ $authorization->end_date }}'
            ];
        @endforeach

        $(document).ready(function() {
            $("#add_user").change(function() {
                add_user();
            });

            $("#amount_preview").change(function() {
                calc_items_users();
                calc_items_clients();
            });

            @if (!isset($data))
                $("#id_authorization").change(function() {
                    let id_authorization = $("#id_authorization").find(":selected").val();

                    $(".table-clients").find(".data").hide();
                    $(".table-clients").find(".data input").val('');

                    if (id_authorization) {
                        authorizations_clients[id_authorization].map(function(id_client) {
                            $(".table-clients").find(`.data[data-id=${id_client}]`).show();
                        });
                    }

                    dates_range();
                    calc_items_clients();
                    calc_total('client_amount', 'client_percentage');
                });
            @endif

            dates_range();
            del_user(0);
            calc_total('user_amount', 'user_percentage');
            calc_total('client_amount', 'client_percentage');
            enable_items_users();
        });

        function dates_range() {
            let id_authorization = $("#id_authorization").find(":selected").val();
            $("#date").removeAttr("min");
            $("#date").removeAttr("max");
            if (id_authorization) {
                console.log(id_authorization, date_range[id_authorization])
                $("#date").attr("min", date_range[id_authorization][0]);
                $("#date").attr("max", date_range[id_authorization][1]);
            }
        }

        function add_user(id_user) {
            if (id_user == undefined) {
                id_user = $("#add_user").find(":selected").val();
            }
            if (id_user) {
                $(".table-users").find(`[name='user_amount[${id_user}]']`).val('');
                $(".table-users").find(`[name='user_amount[${id_user}]_preview']`).val('');
                $(".table-users").find(`[name='user_percentage[${id_user}]']`).val('');
                $(".table-users").find(`.data[data-id=${id_user}]`).show();
                $(".table-users").val('');
                $("#add_user").val('').trigger("chosen:updated");
            }

            if ($(".table-users").find(".data:visible").length > 0 &&
                !$(".table-users").find(".data[data-id={{ auth()->user()->id_user }}]").is(":visible")) {
                add_user({{ auth()->user()->id_user }});
            } else {
                enable_items_users();
                calc_items_users();
            }
        }

        function del_user(id_user) {
            $(".table-users").find(`.data[data-id=${id_user}]`).hide();
            $(".table-users").find(`[name='user_amount[${id_user}]']`).val('');
            $(".table-users").find(`[name='user_amount[${id_user}]_preview']`).val('');
            $(".table-users").find(`[name='user_percentage[${id_user}]']`).val('');

            if ($(".table-users").find(".data:visible").length == 1 &&
                $(".table-users").find(".data[data-id={{ auth()->user()->id_user }}]").is(":visible")) {
                del_user({{ auth()->user()->id_user }});
            } else {
                enable_items_users();
                if (id_user > 0) {
                    calc_items_users();
                }
            }
        }

        function enable_items_users() {
            $(".table-users").find(".data").each(function(index, element) {
                $("#add_user").find(`option[value='${$(this).data('id')}']`)
                    .prop('disabled', $(this).is(':visible'));
            });

            $("#add_user").find(`option[value='{{ auth()->user()->id_user }}']`).prop('disabled', true);
            $("#add_user").trigger("chosen:updated");
        }

        function calc_items_users() {
            let ids = [];
            $(".table-users").find(".data:visible").each(function(index, element) {
                ids.push($(element).data("id"));
            })
            if (!ids[{{ auth()->user()->id_user }}]) {
                ids.push({{ auth()->user()->id_user }});
            }
            calc_items(ids, 'user_amount', 'user_percentage');
        }

        function calc_items_clients() {
            let ids = [];
            $(".table-clients").find(".data:visible").each(function(index, element) {
                ids.push($(element).data("id"));
            })
            calc_items(ids, 'client_amount', 'client_percentage');
        }

        function calc_items(ids, amount_field, percentage_field) {
            let total_amount = +$("#amount").val();
            let partial_amount = total_amount / ids.length;
            let accumulated_amount = 0;

            ids.map(function(id, key) {
                let last = (key + 1 >= ids.length);
                let amount = partial_amount.toFixed(2);
                if (last) {
                    amount = total_amount - accumulated_amount;
                }

                $(`[name='${amount_field}[${id}]']`).val(amount).change();
                calc_percent(amount_field, percentage_field, id);
                accumulated_amount += +amount;
            });
        }

        function calc_percent(amount_field, percentage_field, id) {
            setTimeout(function() {
                let total_amount = +$("#amount").val();
                let amount = +$(`[name='${amount_field}[${id}]']`).val();
                let percentage = (total_amount <= 0 ? 0 : amount / total_amount * 100);

                $(`[name='${percentage_field}[${id}]']`).val(isNaN(percentage) ? 0 : percentage);
                calc_total(amount_field, percentage_field);
            }, 10);
        }

        function calc_amount(amount_field, percentage_field, id) {
            let total_amount = +$("#amount").val();
            let percentage = +$(`[name='${percentage_field}[${id}]']`).val();
            let amount = total_amount * percentage / 100;

            $(`[name='${amount_field}[${id}]']`).val(isNaN(amount) ? 0 : amount.toFixed(2)).change();
            calc_total(amount_field, percentage_field);
        }

        function calc_total(amount_field, percentage_field) {
            let amount_total = 0;
            $(`.${amount_field}`).find("[type=hidden]").each(function(index, element) {
                amount_total += +$(element).val();
            });
            $(`.${amount_field}_total`).html(amount_total.toLocaleString('pt-BR', {
                minimumFractionDigits: 2
            }));

            let percentage_total = 0;
            $(`.${percentage_field}`).find("[type=number]").each(function(index, element) {
                percentage_total += +$(element).val();
            });
            $(`.${percentage_field}_total`).html(percentage_total.toLocaleString('pt-BR', {
                minimumFractionDigits: 2
            }));
        }
    </script>
@endpush
