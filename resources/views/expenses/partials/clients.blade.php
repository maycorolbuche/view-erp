<div class="panel">
    <div class="panel-heading">
        <span class="panel-title">
            <span>Distribuição do valor da despesa por cliente:</span>
        </span>
    </div>

    <div class="panel-body pn">
        <div class="table-responsive">
            <table id="table-clients" class="table table-hover">
                <thead>
                    <tr>
                        <th style="width:30px"></th>
                        <th>Nome</th>
                        <th class="text-right">%</th>
                        <th class="text-right">Valor</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach (collect($authorizations)->pluck('clients')->flatten(1)->unique('id_client')->sortBy('name')->values()->all() as $client)
                        <tr class="data d-none" data-id={{ $client->id_client }}>
                            <td class="check">
                                <x-input type="boolean-checkbox" name="client_check[{{ $client->id_client }}]"
                                    value="{{ (isset($data) && @$data->clients[$client->id_client]['pivot']['amount'] <= 0) || old() ? '' : 'true' }}" />
                            </td>
                            <td>{{ $client->name }}</td>
                            <td class="percentage">
                                <x-input type="number" name="client_percentage[{{ $client->id_client }}]"
                                    value="{{ $data->clients[$client->id_client]['pivot']['percentage'] ?? '0' }}"
                                    min="0" />
                            </td>
                            <td class="amount">
                                <x-input type="money" name="client_amount[{{ $client->id_client }}]"
                                    value="{{ $data->clients[$client->id_client]['pivot']['amount'] ?? '0' }}" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td class="text-bold">Total:</td>
                        <td class="percentage-total text-right text-bold" style="padding-right:20px;"></td>
                        <td class="amount-total text-right text-bold" style="padding-right:20px;">
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>


@push('scripts')
    <script>
        var $clientsTable = $("#table-clients")
        var $clientsTBody = $clientsTable.find("tbody")
        var $clientsTFoot = $clientsTable.find("tfoot")

        $(document).ready(function() {
            @if (!isset($data))
                setTimeout(function() {
                    $("#id_authorization").change(function() {
                        clients_load_grid();
                        clients_check();
                        clients_calc();
                    });
                }, 100);
            @endif

            $("#amount_preview").change(function() {
                clients_calc();
            });

            $clientsTBody.find(".check input").change(function() {
                clients_check()
                clients_calc();
            });

            $clientsTBody.find(".amount input").change(function() {
                let total_amount = +$("#amount").val();
                let percentage = 0
                let amount = toNumber($(this).val());
                if (total_amount !== 0) {
                    percentage = amount / total_amount * 100
                }
                $(this).closest("tr").find(".percentage input").val(percentage.toFixed(2))
                clients_total()
            });

            $clientsTBody.find(".percentage input").change(function() {
                let total_amount = +$("#amount").val();
                let percentage = +$(this).val();
                let amount = total_amount * percentage / 100
                $(this).closest("tr").find(".amount input[type='text']").val(currencyFormat(amount)).blur()
            });

            setTimeout(function() {
                clients_load_grid();
                clients_check();
                @if (!old() && !isset($data))
                    clients_calc();
                @endif
                clients_total()
            }, 10);
        });

        function clients_load_grid() {
            //console.log("clients_load_grid")
            $clientsTBody.find("tr").addClass("d-none")
            $clientsTBody.find("tr").removeClass("row-active");
            $clientsTBody.find("tr").addClass("disabled");

            @if (!isset($data))
                let id_authorization = $("#id_authorization").find(":selected").val();
            @else
                let id_authorization = {{ $data->authorization->id_authorization }};
            @endif

            let authorizations_clients = {};

            @foreach ($authorizations as $authorization)
                authorizations_clients[{{ $authorization->id_authorization }}] = {!! $authorization->clients->toJson() !!};
            @endforeach

            if (id_authorization) {
                let clients = authorizations_clients[id_authorization];

                clients.forEach(function(client) {
                    $clientsTBody.find(`tr[data-id=${client.id_client}]`).removeClass("d-none")
                })
            }
        }

        function clients_check() {
            //console.log("clients_check")
            $clientsTBody.find("tr").each(function(index, tr) {
                if (!$(tr).hasClass("d-none") && $(tr).find(".check input").is(":checked")) {
                    $(tr).addClass("row-active");
                    $(tr).removeClass("disabled");
                    $(tr).find(".percentage input").attr("disabled", false)
                    $(tr).find(".amount input").attr("disabled", false)
                } else {
                    $(tr).removeClass("row-active");
                    $(tr).addClass("disabled");
                    $(tr).find(".percentage input").attr("disabled", true).val(0).blur()
                    $(tr).find(".amount input").attr("disabled", true).val(0).blur()
                }
            });
        }

        function clients_calc() {
            //console.log("clients_calc")
            let $row = $clientsTBody.find("tr.row-active");

            let count = $row.length;
            if (count <= 0) {
                clients_total()
                return
            }

            let amount = +$("#amount").val();
            let quota = amount / count;
            let acc = 0;

            $row.each(function(index, tr) {
                value = +quota.toFixed(2)
                if (index + 1 >= count) {
                    value = +(amount - acc).toFixed(2)
                }
                $(tr).find(`.amount .money`).val(
                    currencyFormat(value)
                ).blur();
                acc += +value
            });
            clients_total()
        }

        function clients_total() {
            //console.log("clients_total");
            let $row = $clientsTBody.find("tr.row-active");

            percentage = 0
            amount = 0
            $row.each(function(index, tr) {
                percentage += +$(tr).find(`.percentage [type='number']`).val();
                amount += toNumber($(tr).find(`.amount [type='text']`).val());
            });

            $clientsTFoot.find(".percentage-total").html(numberFormat(percentage) + "%");
            $clientsTFoot.find(".amount-total").html(currencyFormat(amount));
        }
    </script>
@endpush
