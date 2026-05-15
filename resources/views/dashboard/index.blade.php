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
            <div class="card-dark stat">
                <div class="stat-head"><span class="stat-icon"><i class="bi bi-cash-coin"></i></span> Receita
                    (mês)</div>
                <div class="stat-value">R$ 8,42M</div>
                <div class="stat-delta"><span class="delta-up"><i class="bi bi-arrow-up-right"></i> 12,4%</span>
                    vs mês anterior</div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl">
            <div class="card-dark stat">
                <div class="stat-head"><span class="stat-icon"><i class="bi bi-bullseye"></i></span> SLA Geral
                </div>
                <div class="stat-value">96,7%</div>
                <div class="stat-delta"><span class="delta-up"><i class="bi bi-arrow-up-right"></i> 3,2%</span>
                    vs mês anterior</div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl">
            <div class="card-dark stat">
                <div class="stat-head"><span class="stat-icon"><i class="bi bi-record-circle"></i></span>
                    Projetos Críticos</div>
                <div class="stat-value">12</div>
                <div class="stat-delta"><span class="delta-down"><i class="bi bi-arrow-down-right"></i> 2</span>
                    vs mês anterior</div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl">
            <div class="card-dark stat">
                <div class="stat-head"><span class="stat-icon"><i class="bi bi-building"></i></span> Incidentes
                    Abertos</div>
                <div class="stat-value">28</div>
                <div class="stat-delta"><span class="delta-down"><i class="bi bi-arrow-down-right"></i>
                        15%</span> vs mês anterior</div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl">
            <div class="card-dark stat">
                <div class="stat-head"><span class="stat-icon"><i class="bi bi-graph-up-arrow"></i></span> NPS
                    Interno</div>
                <div class="stat-value">8,7</div>
                <div class="stat-delta"><span class="delta-up"><i class="bi bi-arrow-up-right"></i> 0,8</span> vs
                    mês anterior</div>
            </div>
        </div>
    </div>

    <!-- ROW 2 -->
    <div class="row g-3 mb-3">
        <div class="col-12 col-lg-6 col-xl-4">
            <div class="card-dark h-100">
                <div class="panel-title red">Operação em tempo real</div>
                <div class="list-row">
                    <div class="ico"><i class="bi bi-clipboard-check"></i></div>
                    <div class="grow">
                        <div class="label">Chamados abertos</div>
                        <div class="num">128</div>
                    </div>
                    <div class="pct delta-down"><i class="bi bi-arrow-down-right"></i> 8%</div>
                </div>
                <div class="list-row">
                    <div class="ico"><i class="bi bi-diagram-3"></i></div>
                    <div class="grow">
                        <div class="label">Aprovações pendentes</div>
                        <div class="num">42</div>
                    </div>
                    <div class="pct delta-down"><i class="bi bi-arrow-down-right"></i> 12%</div>
                </div>
                <div class="list-row">
                    <div class="ico"><i class="bi bi-people"></i></div>
                    <div class="grow">
                        <div class="label">Fluxos em execução</div>
                        <div class="num">19</div>
                    </div>
                    <div class="pct delta-up"><i class="bi bi-arrow-up-right"></i> 5%</div>
                </div>
                <div class="list-row">
                    <div class="ico" style="color:var(--bs-primary)"><i class="bi bi-exclamation-octagon"></i></div>
                    <div class="grow">
                        <div class="label">Pendências críticas</div>
                        <div class="num">7</div>
                    </div>
                    <div class="pct delta-down"><i class="bi bi-arrow-down-right"></i> 22%</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6 col-xl-3">
            <div class="card-dark h-100">
                <div class="panel-title">Chamados por prioridade</div>
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
            </div>
        </div>

        <div class="col-12 col-lg-6 col-xl-3">
            <div class="card-dark h-100">
                <div class="panel-title">Projetos em andamento</div>
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
            </div>
        </div>

        <div class="col-12 col-lg-6 col-xl-2">
            <div class="card-dark h-100">
                <div class="panel-title">Feed Corporativo</div>
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
            </div>
        </div>
    </div>

    <!-- ROW 3 -->
    <div class="row g-3">
        <div class="col-12 col-xl-6">
            <div class="card-dark h-100">
                <div class="panel-title">Acesso rápido</div>
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
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-3">
            <div class="card-dark h-100">
                <div class="panel-title">Próximos eventos</div>
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
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-3">
            <div class="card-dark h-100">
                <div class="panel-title">Aniversariantes</div>
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
            </div>
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
