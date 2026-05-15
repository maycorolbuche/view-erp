@extends('layouts.app')
@section('title', $system->name)

@section('content')
    <div class="welcome">
        <h1>Bem-vindo de volta, {{ auth()->user()->name }}! 👋</h1>
        <p>Aqui está o que acontece na View hoje.</p>
    </div>

    <!-- STATS -->
    <div class="row g-3 mb-3" style="position: relative;z-index: 3;">
        <div class="col-12 col-sm-6 col-xl">
            <x-value-card icon="cash-coin" title="Receita (mês)" info-icon="arrow-up-right" info-value="R$ 8,42M"
                info="vs mês anterior">
                R$ 8,42M
            </x-value-card>
        </div>

        <div class="col-12 col-sm-6 col-xl">
            <x-value-card icon="bullseye" title="SLA Geral" info-icon="arrow-up-right" info-value="3,2%"
                info="vs mês anterior">
                96,7%
            </x-value-card>
        </div>

        <div class="col-12 col-sm-6 col-xl">
            <x-value-card icon="record-circle" title="Projetos Críticos" info-icon="arrow-down-right" info-value="2"
                info="vs mês anterior">
                12
            </x-value-card>
        </div>

        <div class="col-12 col-sm-6 col-xl">
            <x-value-card icon="building" title="Incidentes" info-icon="arrow-down-right" info-value="15%"
                info="vs mês anterior">
                28
            </x-value-card>
        </div>

        <div class="col-12 col-sm-6 col-xl">
            <x-value-card icon="graph-up-arrow" title="NPS" info-icon="arrow-up-right" info-value="0,8"
                info="vs mês anterior">
                8,7
            </x-value-card>
        </div>
    </div>

    <!-- ROW 2 -->
    <div class="row g-3 mb-3">

        <div class="col-12 col-lg-6 col-xl-4">
            <x-card title="Operação em tempo real">
                <x-line-card icon="graph-up-arrow" title="NPS" info-icon="arrow-up-right" info-value="0,8">
                    8,7
                </x-line-card>
                <x-line-card icon="clipboard-check" title="Chamados abertos" info-icon="arrow-down-right" info-value="8%">
                    128
                </x-line-card>
                <x-line-card icon="diagram-3" title="Aprovações pendentes" info-icon="arrow-down-right" info-value="12%">
                    42
                </x-line-card>
                <x-line-card icon="people" title="Fluxos em execução" info-icon="arrow-up-right" info-value="5%">
                    19
                </x-line-card>
                <x-line-card icon="exclamation-octagon" title="Pendências críticas" info-icon="arrow-up-right"
                    info-value="22%">
                    7
                </x-line-card>
            </x-card>
        </div>


        <div class="col-12 col-lg-6 col-xl-3">
            <x-card title="Chamados por prioridade">
                <div class="donut-wrap">
                    <div class="donut"></div>
                    <div class="legend">
                        <div class="lg"><span class="dot" style="background:var(--bs-primary)"></span> Alta
                            &nbsp; <strong>28 (22%)</strong></div>
                        <div class="lg"><span class="dot" style="background:#cfd1d6"></span> Média &nbsp;
                            <strong>58 (45%)</strong>
                        </div>
                        <div class="lg"><span class="dot" style="background:#4a4d55"></span> Baixa &nbsp;
                            <strong>42 (33%)</strong>
                        </div>
                    </div>
                </div>
            </x-card>
        </div>

        <div class="col-12 col-lg-6 col-xl-3">
            <x-card title="Projetos em andamento">
                <div class="proj-row">
                    <div class="top"><span>Plataforma Intranet</span><span>75%</span></div>
                    <div class="bar">
                        <div class="fill" style="width:75%"></div>
                    </div>
                </div>
                <div class="proj-row">
                    <div class="top"><span>Migração CRM</span><span>60%</span></div>
                    <div class="bar">
                        <div class="fill" style="width:60%"></div>
                    </div>
                </div>
                <div class="proj-row">
                    <div class="top"><span>IA Interna</span><span>35%</span></div>
                    <div class="bar">
                        <div class="fill" style="width:35%"></div>
                    </div>
                </div>
                <div class="proj-row">
                    <div class="top"><span>Novo ERP</span><span>20%</span></div>
                    <div class="bar">
                        <div class="fill" style="width:20%"></div>
                    </div>
                </div>
                <div class="text-end"><a class="link" href="javascript:">Ver todos</a></div>
            </x-card>
        </div>

        <div class="col-12 col-lg-6 col-xl-2">
            <x-card title="Feed Corporativo">
                <div class="feed-item">
                    <div class="ico"><i class="bi bi-megaphone"></i></div>
                    <div>
                        <div class="tag">Comunicado</div>
                        <div class="txt">Nova política de segurança da informação disponível.</div>
                        <div class="when">há 2h</div>
                    </div>
                </div>
                <div class="feed-item">
                    <div class="ico"><i class="bi bi-people"></i></div>
                    <div>
                        <div class="tag">RH</div>
                        <div class="txt">Programa de treinamento de Liderança 2024.</div>
                        <div class="when">há 1 dia</div>
                    </div>
                </div>
                <div class="feed-item">
                    <div class="ico"><i class="bi bi-tools"></i></div>
                    <div>
                        <div class="tag">TI</div>
                        <div class="txt">Manutenção programada para este sábado.</div>
                        <div class="when">há 1 dia</div>
                    </div>
                </div>
                <div class="text-end mt-2"><a class="link" href="javascript:">Ver todos</a></div>
            </x-card>
        </div>
    </div>

    <!-- ROW 3 -->
    <div class="row g-3">
        <div class="col-12 col-xl-6">
            <x-card title="Acesso rápido">
                <div class="quick">
                    <div class="q">
                        <div class="ic"><i class="bi bi-headset"></i></div>
                        <div class="lbl">Solicitar Serviço</div>
                    </div>
                    <div class="q">
                        <div class="ic"><i class="bi bi-graph-up"></i></div>
                        <div class="lbl">Abrir Chamado</div>
                    </div>
                    <div class="q">
                        <div class="ic"><i class="bi bi-file-earmark-check"></i></div>
                        <div class="lbl">Aprovações</div>
                    </div>
                    <div class="q">
                        <div class="ic"><i class="bi bi-journal-text"></i></div>
                        <div class="lbl">Base de Conhecimento</div>
                    </div>
                    <div class="q">
                        <div class="ic"><i class="bi bi-file-earmark"></i></div>
                        <div class="lbl">Documentos</div>
                    </div>
                    <div class="q">
                        <div class="ic"><i class="bi bi-bar-chart"></i></div>
                        <div class="lbl">Power BI</div>
                    </div>
                </div>
            </x-card>
        </div>

        <div class="col-12 col-md-6 col-xl-3">
            <x-card title="Próximos eventos">
                <div class="event">
                    <div class="date">
                        <div class="d">24</div>
                        <div class="m">MAI</div>
                    </div>
                    <div class="info">
                        <div class="t">Reunião Estratégica</div>
                        <div class="h">09:00 - 10:30</div>
                    </div>
                </div>
                <div class="event">
                    <div class="date">
                        <div class="d">25</div>
                        <div class="m">MAI</div>
                    </div>
                    <div class="info">
                        <div class="t">Workshop Inovação</div>
                        <div class="h">14:00 - 16:00</div>
                    </div>
                </div>
                <div class="event">
                    <div class="date">
                        <div class="d">27</div>
                        <div class="m">MAI</div>
                    </div>
                    <div class="info">
                        <div class="t">Comitê de Segurança</div>
                        <div class="h">10:00 - 11:00</div>
                    </div>
                </div>
                <div class="text-end mt-2"><a class="link" href="javascript:">Ver todos</a></div>
            </x-card>
        </div>

        <div class="col-12 col-md-6 col-xl-3">
            <x-card title="Aniversariantes">
                <div class="bday"><img src="https://i.pravatar.cc/80?img=15">
                    <div>
                        <div class="n">Rafael Almeida</div>
                        <div class="w">Hoje</div>
                    </div>
                </div>
                <div class="bday"><img src="https://i.pravatar.cc/80?img=47">
                    <div>
                        <div class="n">Juliana Costa</div>
                        <div class="w">25 Mai</div>
                    </div>
                </div>
                <div class="bday"><img src="https://i.pravatar.cc/80?img=33">
                    <div>
                        <div class="n">Marcos Paulo</div>
                        <div class="w">27 Mai</div>
                    </div>
                </div>
                <div class="text-end mt-2"><a class="link" href="javascript:">Ver todos</a></div>
            </x-card>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        .welcome {
            position: relative;
            z-index: 2;
            margin-bottom: 20px
        }

        .welcome h1 {
            font-size: clamp(20px, 3.2vw, 30px);
            font-weight: 700;
            margin: 0
        }

        .welcome p {
            color: #b6b9c1;
            margin: 6px 0 0;
            font-size: 14px
        }
    </style>
@endpush
