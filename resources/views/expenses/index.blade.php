@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')
    <x-content>

        <x-panel title="Formulário">

            @include('layouts.partials.messages')

            @if (!isset($data) && count($authorizations) <= 0)
                <x-note type="danger">
                    Você não possui autorizações de despesa em aberto! Não será possível cadastrar despesas.

                    <x-group right>
                        <a type="button" class="btn btn-info" href="{{ route('authorizations-expenses') }}">
                            Solicitar Autorização
                        </a>
                    </x-group>
                </x-note>
            @else
                <x-form action-name="expenses" action-id="{{ isset($data) ? $data->id_expense : null }}" files>
                    <x-group>
                        @if (isset($data))
                            <x-input width="200" label="Autorização" readonly
                                value="{{ $data->authorization->description_details }}" />
                            <input type="hidden" name="id_authorization" value="{{ $data->id_authorization }}">
                        @else
                            @if (old('id_authorization'))
                                @php
                                    $id_authorization = old('id_authorization');
                                @endphp
                            @elseif (count($authorizations) == 1)
                                @push('scripts')
                                    <script>
                                        $(document).ready(function() {
                                            $("#id_authorization")
                                                .val({{ $authorizations[0]->id_authorization }})
                                                .trigger("chosen:updated")
                                                .change();
                                        });
                                    </script>
                                @endpush
                            @endif

                            <x-input type="select" name="id_authorization" width="200" label="Autorização" required
                                list="{{ json_encode($authorizations) }}" list-value="id_authorization"
                                list-text="description_details"
                                value="{{ $data->id_authorization ?? ($id_authorization ?? '') }}" />

                            @push('scripts')
                                <script>
                                    $(document).ready(function() {
                                        setTimeout(function() {
                                            $("#id_authorization")
                                                .trigger("chosen:updated")
                                                .change();
                                        }, 1000)
                                    });
                                </script>
                            @endpush
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

                        <x-input type="file" name="file" width="350" label="Comprovante da Despesa"
                            value="{{ $data->file ?? '' }}" accept=".jpg,.jpeg,.png,.pdf"
                            required="{{ $required_file ? 'required' : '' }}" />
                    </x-group>


                    @include('expenses.partials.clients')

                    @include('expenses.partials.users')

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

        <x-panel title="Dados">
            @include('expenses.components.datatable', ['route' => 'expenses.show'])
        </x-panel>
    </x-content>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            @if (!isset($data))
                $("#id_authorization").change(function() {
                    dates_range();
                });
            @endif
            dates_range();
        });

        function dates_range() {
            @if (!isset($data))
                let id_authorization = $("#id_authorization").find(":selected").val();
            @else
                let id_authorization = {{ $data->authorization->id_authorization }};
            @endif
            $("#date").removeAttr("min");
            $("#date").removeAttr("max");
            if (id_authorization) {
                let date_range = {};

                @foreach ($authorizations as $authorization)
                    date_range[{{ $authorization->id_authorization }}] = [
                        '{{ $authorization->start_date }}', '{{ $authorization->end_date }}'
                    ];
                @endforeach

                $("#date").attr("min", date_range[id_authorization][0]);
                $("#date").attr("max", date_range[id_authorization][1]);
            }
        }
    </script>
@endpush
