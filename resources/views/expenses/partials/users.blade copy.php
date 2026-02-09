<div class="panel">
    <div class="panel-heading">
        <span class="panel-title">
            <span>Distribuição do valor da despesa com outras pessoas: *</span>
        </span>

        <div class="widget-menu pull-right mr10">
            <button type="button" class="btn btn-xs btn-success" data-url="{{ route('users-search') }}"
                data-callback="selectClient">
                <span class="glyphicons glyphicons-user mr5"></span>
                Adicionar Pessoa
            </button>
        </div>
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
                        <td colspan=3>
                            <select class="chosen-select">
                                <option selected disabled>Selecionar</option>

                            </select>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr class="data fixed">
                        <td>{{ auth()->user()->name }}</td>
                        <td class="percentage">
                            <x-input type="number" name="user_percentage[{{ auth()->user()->id_client }}]"
                                value="0" data-value="__percentage__" min="0" />
                        </td>
                        <td class="amount">
                            <x-input type="money" name="user_amount[1]" value="0" data-value="__amount__" />
                        </td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div style="padding:5px;">
            <small>* Utilize este espaço para informar se a sua despesa inclui outras pessoas</small>
        </div>
    </div>
</div>

<script>
    function selectClient(data) {
        console.log("Dados recebidos", data)
    }
</script>
