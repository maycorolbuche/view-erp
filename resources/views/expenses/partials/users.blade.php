@php
    $users = [['id_user' => auth()->user()->id_user, 'name' => auth()->user()->name], ...$users->toArray()];
@endphp

<div class="panel">
    <div class="panel-heading">
        <span class="panel-title">
            <span>Distribuição do valor da despesa com outras pessoas: *</span>
        </span>
    </div>
    <div class="panel-body pn">
        <div class="table-responsive">
            <table id="table-users" class="table table-hover">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th class="text-right">%</th>
                        <th class="text-right">Valor</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td colspan=2 class="text-right" style="font-weight:bold">
                            Adicionar usuário:
                        </td>
                        <td colspan=2>
                            <select id="search-user" class="chosen-select search-user">
                                <option value="-1" selected disabled>Selecionar usuário</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user['id_user'] }}">{{ $user['name'] }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        @php
                            $visible =
                                isset($data->users[$user['id_user']]['pivot']['amount']) &&
                                $data->users[$user['id_user']]['pivot']['amount'] > 0;

                            if (old() && old('user_amount')[$user['id_user']] > 0) {
                                $visible = true;
                            }

                            $self = auth()->user()->id_user == $user['id_user'];
                        @endphp
                        <tr class="data {{ $self ? 'fixed' : '' }} {{ !$self && !$visible ? 'd-none' : '' }}"
                            data-id={{ $user['id_user'] }}>
                            <td>{{ $user['name'] }}</td>
                            <td class="percentage">
                                <x-input type="number" name="user_percentage[{{ $user['id_user'] }}]"
                                    value="{{ $data->users[$user['id_user']]['pivot']['percentage'] ?? '0' }}"
                                    min="0" />
                            </td>
                            <td class="amount">
                                <x-input type="money" name="user_amount[{{ $user['id_user'] }}]"
                                    value="{{ $data->users[$user['id_user']]['pivot']['amount'] ?? '0' }}" />
                            </td>
                            <td>
                                @if (!$self)
                                    <a class="btn btn-danger" href="javascript:"
                                        onclick="users_remove({{ $user['id_user'] }})">
                                        <i class="far fa-trash-alt"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-bold">Total:</td>
                        <td class="percentage-total text-right text-bold" style="padding-right:20px;"></td>
                        <td class="amount-total text-right text-bold" style="padding-right:20px;">
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div style="padding:5px;">
            <small>* Utilize este espaço para informar se a sua despesa inclui outras pessoas</small>
        </div>
    </div>
</div>

@push('scripts')
    <style>
        #table-users tr.fixed {
            background: #e9ecef;
        }
    </style>
    <script>
        var $usersTable = $("#table-users")
        var $usersTBody = $usersTable.find("tbody")
        var $usersTFoot = $usersTable.find("tfoot")

        $(document).ready(function() {
            $usersTable.find(".search-user").change(function() {
                users_add($(this).val())
            });

            $("#amount_preview").change(function() {
                users_calc();
            });

            $usersTBody.find(".amount input").change(function() {
                let total_amount = +$("#amount").val();
                let percentage = 0
                let amount = toNumber($(this).val());
                if (total_amount !== 0) {
                    percentage = amount / total_amount * 100
                }
                $(this).closest("tr").find(".percentage input").val(percentage.toFixed(2))
                users_total()
            });

            $usersTBody.find(".percentage input").change(function() {
                let total_amount = +$("#amount").val();
                let percentage = +$(this).val();
                let amount = total_amount * percentage / 100
                $(this).closest("tr").find(".amount input[type='text']").val(currencyFormat(amount)).blur()
            });

            setTimeout(function() {
                users_check();
                @if (!old() && !isset($data))
                    users_calc();
                @endif
                users_total()
            }, 10);
        });

        function users_add(id_user) {
            //console.log("users_add")
            if ($usersTBody.find(`[data-id=${id_user}]`).hasClass("d-none")) {
                $usersTBody.find(`[data-id=${id_user}]`).removeClass("d-none")
                users_check()
                users_calc()
            } else {
                new PNotify({
                    title: 'Alerta',
                    text: 'Pessoa já inserida!',
                    type: 'warning',
                    delay: 1400
                });

            }
            $usersTable.find(".search-user").val("-1").trigger('chosen:updated');
        }

        function users_remove(id_user) {
            //console.log("users_remove")
            $usersTBody.find(`[data-id=${id_user}]`).addClass("d-none")
            users_check()
            users_calc()
        }

        function users_check(id_user) {
            //console.log("users_check")

            $usersTBody.find("tr").each(function(index, tr) {
                id_user = $(tr).data("id")
                $selectOption = $usersTable.find(".search-user").find(`option[value=${id_user}]`)

                if (!$(tr).hasClass("d-none") || $(tr).hasClass("fixed")) {
                    $(tr).addClass("row-active");
                    $selectOption.prop('disabled', true).trigger('chosen:updated');
                } else {
                    $(tr).removeClass("row-active");
                    $(tr).find(".percentage input").val(0).blur()
                    $(tr).find(".amount input").val(0).blur()
                    $selectOption.prop('disabled', false).trigger('chosen:updated');
                }

                if ($usersTBody.find("tr.row-active").length <= 1) {
                    $usersTBody.find("tr.fixed").addClass("d-none")
                    $usersTFoot.addClass("d-none")
                } else {
                    $usersTBody.find("tr.fixed").removeClass("d-none")
                    $usersTFoot.removeClass("d-none")
                }
            });
        }

        function users_calc() {
            //console.log("users_calc")
            let $row = $usersTBody.find("tr.row-active");

            let count = $row.length;
            if (count <= 0) {
                users_total()
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
            users_total()
        }

        function users_total() {
            //console.log("users_total")
            let $row = $usersTBody.find("tr.row-active");

            percentage = 0
            amount = 0
            $row.each(function(index, tr) {
                percentage += +$(tr).find(`.percentage [type='number']`).val();
                amount += toNumber($(tr).find(`.amount [type='text']`).val());
            });

            $usersTFoot.find(".percentage-total").html(numberFormat(percentage) + "%");
            $usersTFoot.find(".amount-total").html(currencyFormat(amount));
        }
    </script>
@endpush
