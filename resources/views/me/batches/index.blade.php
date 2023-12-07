@extends('layouts.app')
@section('title', 'Consulta de Lotes')
@section('breadcrumb', json_encode([['label' => 'Autorização de Despesas', 'icon' => 'fas fa-check-double']]))

@section('content')
    <x-content>

        @if (isset($data))

            @php
                $edit = false;
                if (isset($data) && $data->active) {
                    $edit = true;
                }
            @endphp

            <x-panel title="Detalhes do Lote" type="info">

                @include('layouts.partials.messages')

                <x-form action-name="me-batches" action-id="{{ isset($data) ? $data->id_batch : null }}">

                    <x-group>
                        <x-card>
                            <div class="pn pl20 p5">
                                <div class="icon-bg"> <i class="fa fa-comments-o"></i> </div>
                                <h2 class="mt15 lh15"> <b>523</b> </h2>
                                <h5 class="text-muted">Comments</h5>
                            </div>
                        </x-card>
                        <div class="col-md-3">
                            <div class="panel bg-alert light of-h mb10">
                                <div class="pn pl20 p5">
                                    <div class="icon-bg"> <i class="fa fa-comments-o"></i> </div>
                                    <h2 class="mt15 lh15"> <b>523</b> </h2>
                                    <h5 class="text-muted">Comments</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="panel bg-info light of-h mb10">
                                <div class="pn pl20 p5">
                                    <div class="icon-bg"> <i class="fa fa-twitter"></i> </div>
                                    <h2 class="mt15 lh15"> <b>348</b> </h2>
                                    <h5 class="text-muted">Tweets</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="panel bg-danger light of-h mb10">
                                <div class="pn pl20 p5">
                                    <div class="icon-bg"> <i class="fa fa-bar-chart-o"></i> </div>
                                    <h2 class="mt15 lh15"> <b>267</b> </h2>
                                    <h5 class="text-muted">Reach</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="panel bg-warning light of-h mb10">
                                <div class="pn pl20 p5">
                                    <div class="icon-bg"> <i class="fa fa-envelope"></i> </div>
                                    <h2 class="mt15 lh15"> <b>714</b> </h2>
                                    <h5 class="text-muted">Comments</h5>
                                </div>
                            </div>
                        </div>
                    </x-group>

                    <x-group>
                        <x-input type="html" width="100" label="Código do Lote">
                            <div class="text-right form-control">{{ $data->id_batch }}</div>
                        </x-input>
                        <x-input type="html" width="100" label="Qtd. Despesas">
                            <div class="text-right form-control">{{ $data->expenses_count }}</div>
                        </x-input>
                        <x-input type="html" width="140" label="Valor do Lote">
                            <div class="text-right form-control">{{ number_format($data->amount, 2, ',', '.') }}</div>
                        </x-input>
                        <x-input type="html" width="160" label="(-) Vl. não Reembolsável">
                            <div class="text-right form-control">
                                {{ number_format($data->non_refundable_amount, 2, ',', '.') }}
                            </div>
                        </x-input>
                        <x-input type="html" width="140" label="(-) Vl. Desconto">
                            <div class="text-right form-control">.....</div>
                        </x-input>
                        <x-input type="html" width="140" label="(=) Vl. Reembolso">
                            <div class="text-right form-control">.....</div>
                        </x-input>
                    </x-group>

                    <x-group right>
                        @if ($edit)
                            <x-button type="delete" label="Desfazer Lote" />
                        @endif
                        <x-button type="cancel" route-name="me-batches" />
                    </x-group>

                </x-form>
            </x-panel>
        @endif

        <x-panel title="Dados" type="warning">
            @include('me.batches.components.datatable', ['route' => 'me-batches.show'])
        </x-panel>
    </x-content>
@endsection
