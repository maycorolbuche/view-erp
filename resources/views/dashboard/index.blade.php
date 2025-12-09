@extends('layouts.app')
@section('title', $system->name)

@section('content')

    <div class="tray tray-center ph30 va-t posr animated-delay animated-long" data-animate='["800","fadeIn"]'>
        <div class="center-block">

            <h2 class="lh30 mt10 text-center">Olá <b class="text-primary">{{ $user->name }}</b>!</h2>
            <p class="lead mb35 text-center">
                Navegue pelos módulos disponíveis no menu esquerdo.
            </p>


            @if (count($pages) <= 0)
                <div style="display: flex;flex-wrap: wrap;align-items: stretch;justify-content: space-between;">
                    <div style="flex-grow: 1;margin-right: 15px;" class="alert alert-danger alert-dismissable">
                        <h3 class="mt5">Sem Módulos Autorizados</h3>
                        <p>Não existe nenhum módulo disponível em seu perfil.</p>
                        <p>Entre em contato com o administrador do sistema para te conceder os acessos necessários.</p>
                    </div>
                </div>
            @endif

            @if (isset($permissions['batch-review']) && $batch_review_count > 0)
                <div style="display: flex;flex-wrap: wrap;align-items: stretch;justify-content: space-between;">
                    <div style="flex-grow: 1;margin-right: 15px;" class="alert alert-warning alert-dismissable">
                        <h3 class="mt5">Revisões Pendentes!</h3>

                        <p>Você tem revisões de lotes pendentes.</p>
                        <p>É necessário revisar os lotes, para que o pagamento seja efetuado corretamente.</p>
                        <br>
                        <p>
                            <a class="btn btn-warning" href="{{ route('batch-review') }}">Revisar Lotes</a>
                        </p>
                    </div>

                    <div class="panel panel-tile text-center">
                        <div class="panel-heading hidden">
                            <span class="panel-title"><i class="fa fa-pencil"></i> Title</span>
                        </div>
                        <div class="panel-body bg-warning">
                            <h1 class="fs35 mbn">{{ number_format($batch_review_count, 0, ',', '.') }}</h1>
                            <h6 class="text-white">{{ $batch_review_count == 1 ? 'LOTE' : 'LOTES' }}</h6>
                        </div>
                        <div class="panel-footer br-n p12">
                            <span class="fs11">
                                <b>REVISÕES PENDENTES</b>
                            </span>
                        </div>
                    </div>
                </div>
            @endif

            @if (isset($permissions['batch-payments']) && $batch_payments_count > 0)
                <div style="display: flex;flex-wrap: wrap;align-items: stretch;justify-content: space-between;">
                    <div style="flex-grow: 1;margin-right: 15px;" class="alert alert-warning alert-dismissable">
                        <h3 class="mt5">Pagamentos Pendentes!</h3>

                        <p>Você tem pagamentos de lotes pendentes.</p>
                        <p>É necessário registrar o pagamento nos lotes, para que a baixa seja efetuada corretamente.</p>
                        <br>
                        <p>
                            <a class="btn btn-warning" href="{{ route('batch-payments') }}">Registrar Pagamentos</a>
                        </p>
                    </div>

                    <div class="panel panel-tile text-center">
                        <div class="panel-heading hidden">
                            <span class="panel-title"><i class="fa fa-pencil"></i> Title</span>
                        </div>
                        <div class="panel-body bg-warning">
                            <h1 class="fs35 mbn">{{ number_format($batch_payments_count, 0, ',', '.') }}</h1>
                            <h6 class="text-white">{{ $batch_payments_count == 1 ? 'LOTE' : 'LOTES' }}</h6>
                        </div>
                        <div class="panel-footer br-n p12">
                            <span class="fs11">
                                <b>PAGAMENTOS PENDENTES</b>
                            </span>
                        </div>
                    </div>
                </div>
            @endif

            @if ($authorizations_pending_count > 0)
                <div style="display: flex;flex-wrap: wrap;align-items: stretch;justify-content: space-between;">
                    <div style="flex-grow: 1;margin-right: 15px;" class="alert alert-warning alert-dismissable">
                        <h3 class="mt5">Autorizações Pendentes!</h3>

                        <p>Você tem autorizações pendentes de aprovação.</p>
                        <br>
                        <p>
                            <a class="btn btn-warning" href="{{ route('me-authorizations') }}">Ver Autorizações</a>
                        </p>
                    </div>

                    <div class="panel panel-tile text-center">
                        <div class="panel-heading hidden">
                            <span class="panel-title"><i class="fa fa-pencil"></i> Title</span>
                        </div>
                        <div class="panel-body bg-warning">
                            <h1 class="fs35 mbn">{{ number_format($authorizations_pending_count, 0, ',', '.') }}</h1>
                        </div>
                        <div class="panel-footer br-n p12">
                            <span class="fs11">
                                <b>AUTORIZAÇÕES PENDENTES</b>
                            </span>
                        </div>
                    </div>
                </div>
            @endif

            @if (count($pages) > 0)
                <div class="panel mobile-controls" id="p10">
                    <div class="panel-heading ui-sortable-handle">
                        <span class="panel-title">Módulos do Sistema</span>
                        <span class="panel-controls" data-original-title="" title=""><a href="#"
                                class="panel-control-loader"></a><a href="#" class="panel-control-remove"></a><a
                                href="#" class="panel-control-title"></a><a href="#"
                                class="panel-control-color"></a><a href="#" class="panel-control-collapse"></a><a
                                href="#" class="panel-control-fullscreen"></a></span>
                    </div>
                    <div class="panel-body pn">
                        <div
                            style="display: flex;flex-wrap: wrap;align-items: center;justify-content: center;margin-top: 10px;">
                            @foreach ($pages as $group)
                                <div style="padding:0 5px;width: 300px;" class="btn-group">
                                    <div class="panel panel-tile bg-primary light of-h mb10 dropdown-toggle"
                                        data-toggle="dropdown" aria-expanded="false" style="cursor:pointer;">
                                        <div class="panel-body pn pl20 p5">
                                            <div class="icon-bg">
                                                <i class="{{ $group['icon'] }}"></i>
                                            </div>
                                            <h4 class="mt15 lh15">
                                                <b>{{ $group['label'] }}</b>
                                            </h4>
                                            <h5 class="text-muted">{{ $group['label'] }}</h5>
                                        </div>
                                    </div>
                                    <ul class="dropdown-menu" role="menu">
                                        @foreach ($group['items'] as $item)
                                            <li>
                                                <a href="{{ route($item['route']['name']) }}">
                                                    {{ $item['route']['label'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

@endsection


@section('right')
    dsfdsfdsfdsfd
@endsection
