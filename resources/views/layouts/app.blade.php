<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>VIEW Intranet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #0a0a0c;
            --panel: #0f1013;
            --panel-2: #141519;
            --card: #15161b;
            --card-border: #1f2026;
            --text: #e9eaee;
            --muted: #8a8d96;
            --red: #ff2b3d;
            --red-soft: #ff4757;
            --red-dim: #3a1014;
            --green: #22c55e;
            --sidebar-w: 260px;
            --sidebar-w-collapsed: 72px;
        }

        * {
            box-sizing: border-box
        }

        html,
        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased
        }

        body {
            min-height: 100vh;
            overflow-x: hidden
        }

        a {
            text-decoration: none;
            color: inherit
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: var(--sidebar-w);
            background: var(--panel);
            border-right: 1px solid #15161b;
            padding: 18px 14px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            z-index: 1040;
            transition: width .25s ease, transform .3s ease;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar::-webkit-scrollbar {
            width: 6px
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #23242b;
            border-radius: 4px
        }

        .brand {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 6px 10px 18px;
            white-space: nowrap
        }

        .brand-text {
            display: flex;
            align-items: baseline;
            gap: 8px;
            overflow: hidden
        }

        .brand .logo {
            font-weight: 800;
            font-size: 26px;
            color: var(--red);
            letter-spacing: .5px;
            line-height: 1
        }

        .brand .sub {
            font-size: 10.5px;
            letter-spacing: .28em;
            color: #cfd1d6;
            font-weight: 600
        }

        .collapse-btn {
            background: transparent;
            border: 0;
            color: #9ea2ab;
            font-size: 18px;
            cursor: pointer;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .collapse-btn:hover {
            background: #17181d;
            color: #fff
        }

        .nav-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            padding: 10px 12px;
            border-radius: 10px;
            color: #c9ccd3;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            position: relative;
            transition: .2s;
            white-space: nowrap;
            border: 0;
            background: transparent;
            width: 100%;
            text-align: left;
        }

        .nav-item .left {
            display: flex;
            align-items: center;
            gap: 14px;
            min-width: 0;
            overflow: hidden
        }

        .nav-item .label {
            overflow: hidden;
            text-overflow: ellipsis
        }

        .nav-item i.bi {
            font-size: 18px;
            color: #9ea2ab;
            flex-shrink: 0
        }

        .nav-item:hover {
            background: #17181d;
            color: #fff
        }

        .nav-item.active {
            background: linear-gradient(90deg, rgba(255, 43, 61, .14), rgba(255, 43, 61, 0));
            color: #fff;
        }

        .nav-item.active i.bi {
            color: var(--red)
        }

        .nav-item.active::before {
            content: "";
            position: absolute;
            left: -14px;
            top: 6px;
            bottom: 6px;
            width: 3px;
            background: var(--red);
            border-radius: 2px;
        }

        .nav-item .chev {
            color: #5a5d65;
            font-size: 13px;
            transition: transform .25s
        }

        .nav-item[aria-expanded="true"] .chev {
            transform: rotate(90deg);
            color: var(--red)
        }

        .submenu {
            list-style: none;
            margin: 2px 0 4px;
            padding: 2px 0 2px 38px;
            display: none;
            flex-direction: column;
            gap: 2px;
            border-left: 1px solid #1f2026;
            margin-left: 22px;
        }

        .submenu.open {
            display: flex
        }

        .submenu a {
            display: block;
            padding: 7px 12px;
            border-radius: 8px;
            font-size: 13px;
            color: #a8abb3;
            transition: .15s;
        }

        .submenu a:hover {
            background: #17181d;
            color: #fff
        }

        .submenu a.active {
            color: var(--red)
        }

        .user-card {
            margin-top: auto;
            background: #16171c;
            border: 1px solid #1d1e24;
            border-radius: 14px;
            padding: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            white-space: nowrap;
        }

        .user-card img {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0
        }

        .user-card .name {
            font-weight: 600;
            font-size: 13.5px
        }

        .user-card .role {
            font-size: 11.5px;
            color: var(--muted)
        }

        .user-card .grow {
            min-width: 0;
            overflow: hidden
        }

        /* COLLAPSED (icons-only) */
        .sidebar.collapsed {
            width: var(--sidebar-w-collapsed)
        }

        .sidebar.collapsed .brand-text,
        .sidebar.collapsed .nav-item .label,
        .sidebar.collapsed .nav-item .chev,
        .sidebar.collapsed .user-card .grow,
        .sidebar.collapsed .user-card>.chev,
        .sidebar.collapsed .submenu {
            display: none !important
        }

        .sidebar.collapsed .brand {
            justify-content: center;
            padding: 6px 0 18px
        }

        .sidebar.collapsed .nav-item {
            justify-content: center;
            padding: 11px 0
        }

        .sidebar.collapsed .nav-item .left {
            justify-content: center;
            gap: 0
        }

        .sidebar.collapsed .nav-item.active::before {
            left: 0
        }

        .sidebar.collapsed .user-card {
            justify-content: center;
            padding: 8px
        }

        /* Tooltip on hover when collapsed */
        .sidebar.collapsed .nav-item[data-tip]:hover::after {
            content: attr(data-tip);
            position: absolute;
            left: calc(100% + 10px);
            top: 50%;
            transform: translateY(-50%);
            background: #1d1e24;
            color: #fff;
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 12px;
            white-space: nowrap;
            z-index: 1050;
            border: 1px solid #2a2b32;
        }

        /* MAIN */
        .main {
            margin-left: var(--sidebar-w);
            padding: 20px 28px 40px;
            position: relative;
            transition: margin-left .25s ease
        }

        body.sidebar-collapsed .main {
            margin-left: var(--sidebar-w-collapsed)
        }

        .hero-bg {
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            height: 300px;
            background:
                radial-gradient(ellipse at 75% 30%, rgb(127 12 21 / 35%), transparent 55%), radial-gradient(ellipse at 90% 60%, rgb(0 0 0 / 18%), transparent 60%), #0a0a0c;
            overflow: hidden;
            z-index: 0;
            pointer-events: none;
        }

        .hero-bg::after {
            content: "";
            position: absolute;
            inset: 0;

            background-image:
                radial-gradient(circle, rgba(255, 80, 95, .55) 0 1px, transparent 1.5px),
                radial-gradient(circle, rgba(255, 80, 95, .40) 0 1px, transparent 1.5px),
                radial-gradient(circle, rgba(255, 80, 95, .30) 0 1px, transparent 1.5px),
                radial-gradient(circle, rgba(255, 80, 95, .50) 0 1px, transparent 1.5px),
                radial-gradient(circle, rgba(255, 80, 95, .25) 0 1px, transparent 1.5px);

            background-size:
                60px 60px,
                90px 90px,
                120px 120px,
                75px 75px,
                140px 140px;

            background-position:
                0 0,
                20px 40px,
                50px 10px,
                80px 30px,
                120px 60px;

            opacity: .9;

            mask-image: linear-gradient(to left, #000 0%, transparent 70%);

            animation: heroParticles 18s linear infinite;
        }

        @keyframes heroParticles {
            0% {
                background-position:
                    0 0,
                    20px 40px,
                    50px 10px,
                    80px 30px,
                    120px 60px;
            }

            25% {
                background-position:
                    30px -20px,
                    -10px 70px,
                    90px 40px,
                    50px 10px,
                    160px 20px;
            }

            50% {
                background-position:
                    60px -40px,
                    -40px 100px,
                    130px 80px,
                    20px -10px,
                    200px -20px;
            }

            75% {
                background-position:
                    30px -60px,
                    -70px 130px,
                    170px 120px,
                    -10px -30px,
                    240px -60px;
            }

            100% {
                background-position:
                    0 -80px,
                    -100px 160px,
                    210px 160px,
                    -40px -50px,
                    280px -100px;
            }
        }

        .topbar {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 28px;
            flex-wrap: wrap
        }

        .mobile-toggle {
            display: none;
            background: #16171c;
            border: 1px solid #1d1e24;
            color: #fff;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            cursor: pointer;
        }

        .search {
            flex: 1;
            min-width: 200px;
            max-width: 520px;
            background: #16171c;
            border: 1px solid #1d1e24;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            color: var(--muted);
        }

        .search input {
            background: transparent;
            border: 0;
            outline: 0;
            color: var(--text);
            width: 100%;
            font-size: 14px;
        }

        .search input::placeholder {
            color: #7a7d85
        }

        .top-actions {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 16px;
            color: #cfd1d6;
            font-size: 19px;
            flex-wrap: wrap
        }

        .top-actions .ic {
            position: relative;
            cursor: pointer
        }

        .top-actions .ic .dot {
            position: absolute;
            top: -3px;
            right: -5px;
            background: var(--red);
            color: #fff;
            font-size: 10px;
            min-width: 16px;
            height: 16px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            padding: 0 4px;
        }

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

        /* CARDS */
        .card-dark {
            background: var(--card);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            padding: 18px;
        }

        .stat .stat-head {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #c9ccd3;
            font-size: 14px
        }

        .stat .stat-icon {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background: #1d1e24;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--red);
            font-size: 15px;
        }

        .stat .stat-value {
            font-size: clamp(22px, 2.5vw, 30px);
            font-weight: 700;
            margin: 14px 0 10px;
            letter-spacing: -.5px
        }

        .stat .stat-delta {
            font-size: 12.5px;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap
        }

        .delta-up,
        .delta-down {
            color: var(--red)
        }

        .panel-title {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 14px
        }

        .panel-title.red {
            color: var(--red)
        }

        .list-row {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px;
            border-radius: 12px;
            background: #101115;
            margin-bottom: 10px;
        }

        .list-row .ico {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: #1a1b21;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #cfd1d6;
            flex-shrink: 0;
        }

        .list-row .grow {
            flex: 1;
            min-width: 0
        }

        .list-row .label {
            font-size: 13px;
            color: #c0c3cb
        }

        .list-row .num {
            font-size: 18px;
            font-weight: 700
        }

        .pct {
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px
        }

        /* DONUT */
        .donut-wrap {
            display: flex;
            align-items: center;
            gap: 22px;
            flex-wrap: wrap
        }

        .donut {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: conic-gradient(var(--red) 0 22%,
                    #cfd1d6 22% 67%,
                    #4a4d55 67% 100%);
            position: relative;
            flex-shrink: 0;
        }

        .donut::after {
            content: "";
            position: absolute;
            inset: 18px;
            background: var(--card);
            border-radius: 50%
        }

        .legend {
            display: flex;
            flex-direction: column;
            gap: 12px;
            font-size: 13.5px
        }

        .legend .lg {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #cfd1d6
        }

        .legend .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%
        }

        /* PROGRESS */
        .proj-row {
            margin-bottom: 14px
        }

        .proj-row .top {
            display: flex;
            justify-content: space-between;
            font-size: 13.5px;
            color: #d3d5dc;
            margin-bottom: 8px;
            gap: 10px
        }

        .proj-row .bar {
            height: 6px;
            background: #23242b;
            border-radius: 4px;
            overflow: hidden
        }

        .proj-row .fill {
            height: 100%;
            background: linear-gradient(90deg, var(--red), #ff5868);
            border-radius: 4px
        }

        /* FEED */
        .feed-item {
            display: flex;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid #1c1d23
        }

        .feed-item:last-child {
            border: 0
        }

        .feed-item .ico {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: #1a1b21;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #cfd1d6;
            flex-shrink: 0;
        }

        .feed-item .tag {
            font-size: 12px;
            color: var(--red);
            font-weight: 600;
            margin-bottom: 2px
        }

        .feed-item .txt {
            font-size: 13px;
            color: #c8cad1;
            line-height: 1.35
        }

        .feed-item .when {
            font-size: 11.5px;
            color: #6f727a;
            margin-top: 4px
        }

        /* QUICK */
        .quick {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 14px
        }

        .quick .q {
            background: #101115;
            border: 1px solid #1c1d23;
            border-radius: 14px;
            padding: 16px 8px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: .2s;
        }

        .quick .q:hover {
            border-color: var(--red);
            transform: translateY(-2px)
        }

        .quick .q .ic {
            width: 42px;
            height: 42px;
            border-radius: 11px;
            background: #1a1b21;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #dfe1e7;
            font-size: 18px;
        }

        .quick .q .lbl {
            font-size: 12.5px;
            color: #c8cad1;
            line-height: 1.25
        }

        /* EVENTS */
        .event {
            display: flex;
            gap: 14px;
            padding: 10px 0;
            border-bottom: 1px solid #1c1d23
        }

        .event:last-child {
            border: 0
        }

        .event .date {
            text-align: center;
            min-width: 38px
        }

        .event .date .d {
            font-size: 22px;
            font-weight: 700;
            color: var(--red);
            line-height: 1
        }

        .event .date .m {
            font-size: 10px;
            color: var(--red);
            font-weight: 700;
            letter-spacing: .1em
        }

        .event .info .t {
            font-size: 13.5px;
            color: #dfe1e7;
            font-weight: 500
        }

        .event .info .h {
            font-size: 12px;
            color: #7a7d85;
            margin-top: 2px
        }

        /* BIRTHDAYS */
        .bday {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid #1c1d23
        }

        .bday:last-child {
            border: 0
        }

        .bday img {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover
        }

        .bday .n {
            font-size: 13.5px;
            font-weight: 500
        }

        .bday .w {
            font-size: 12px;
            color: #7a7d85
        }

        .ver-todos {
            color: var(--red);
            font-size: 12.5px;
            font-weight: 600;
            cursor: pointer
        }

        /* OVERLAY */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .55);
            z-index: 1030;
        }

        .sidebar-overlay.show {
            display: block
        }

        /* RESPONSIVE */
        @media (max-width: 1399.98px) {
            .quick {
                grid-template-columns: repeat(4, 1fr)
            }
        }

        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%)
            }

            .sidebar.open {
                transform: none;
                width: var(--sidebar-w)
            }

            body.sidebar-collapsed .main {
                margin-left: 0
            }

            .main {
                margin-left: 0;
                padding: 16px
            }

            .mobile-toggle {
                display: flex
            }

            .collapse-btn {
                display: none
            }

            .quick {
                grid-template-columns: repeat(3, 1fr)
            }
        }

        @media (max-width: 575.98px) {
            .main {
                padding: 14px
            }

            .top-actions {
                gap: 12px;
                font-size: 17px;
                width: 100%;
                justify-content: flex-start;
                order: 3
            }

            .search {
                order: 2;
                max-width: none
            }

            .quick {
                grid-template-columns: repeat(2, 1fr)
            }

            .donut {
                width: 130px;
                height: 130px
            }

            .donut::after {
                inset: 16px
            }

            .card-dark {
                padding: 14px
            }

            .hero-bg {
                height: 220px
            }
        }
    </style>
</head>

<body>

    <div class="sidebar-overlay" id="overlay"></div>

    <aside class="sidebar" id="sidebar">
        <div class="brand">
            <div class="brand-text">
                <span class="logo">VIEW</span><span class="sub">INTRANET</span>
            </div>
            <button class="collapse-btn d-none d-lg-flex" id="collapseBtn" title="Recolher menu">
                <i class="bi bi-list"></i>
            </button>
        </div>

        <button class="nav-item active" data-tip="Home">
            <div class="left"><i class="bi bi-house-door"></i><span class="label">Home</span></div>
        </button>

        <button class="nav-item" data-tip="Operações" data-toggle-sub="sub-op" aria-expanded="false">
            <div class="left"><i class="bi bi-grid"></i><span class="label">Operações</span></div>
            <i class="bi bi-chevron-right chev"></i>
        </button>
        <ul class="submenu" id="sub-op">
            <li><a href="#">Visão geral</a></li>
            <li><a href="#">Chamados</a></li>
            <li><a href="#">SLA</a></li>
            <li><a href="#">Indicadores</a></li>
        </ul>

        <button class="nav-item" data-tip="Projetos" data-toggle-sub="sub-pj" aria-expanded="false">
            <div class="left"><i class="bi bi-kanban"></i><span class="label">Projetos</span></div>
            <i class="bi bi-chevron-right chev"></i>
        </button>
        <ul class="submenu" id="sub-pj">
            <li><a href="#">Em andamento</a></li>
            <li><a href="#">Backlog</a></li>
            <li><a href="#">Concluídos</a></li>
        </ul>

        <button class="nav-item" data-tip="TI" data-toggle-sub="sub-ti" aria-expanded="false">
            <div class="left"><i class="bi bi-cpu"></i><span class="label">TI</span></div>
            <i class="bi bi-chevron-right chev"></i>
        </button>
        <ul class="submenu" id="sub-ti">
            <li><a href="#">Infraestrutura</a></li>
            <li><a href="#">Suporte</a></li>
            <li><a href="#">Segurança</a></li>
            <li><a href="#">Desenvolvimento</a></li>
        </ul>

        <button class="nav-item" data-tip="RH" data-toggle-sub="sub-rh" aria-expanded="false">
            <div class="left"><i class="bi bi-people"></i><span class="label">RH</span></div>
            <i class="bi bi-chevron-right chev"></i>
        </button>
        <ul class="submenu" id="sub-rh">
            <li><a href="#">Colaboradores</a></li>
            <li><a href="#">Recrutamento</a></li>
            <li><a href="#">Treinamentos</a></li>
            <li><a href="#">Benefícios</a></li>
        </ul>

        <button class="nav-item" data-tip="Financeiro" data-toggle-sub="sub-fin" aria-expanded="false">
            <div class="left"><i class="bi bi-pie-chart"></i><span class="label">Financeiro</span></div>
            <i class="bi bi-chevron-right chev"></i>
        </button>
        <ul class="submenu" id="sub-fin">
            <li><a href="#">Contas a pagar</a></li>
            <li><a href="#">Contas a receber</a></li>
            <li><a href="#">Orçamento</a></li>
            <li><a href="#">Relatórios</a></li>
        </ul>

        <button class="nav-item" data-tip="Jurídico & Compliance" data-toggle-sub="sub-jur" aria-expanded="false">
            <div class="left"><i class="bi bi-shield-lock"></i><span class="label">Jurídico &amp;
                    Compliance</span></div>
            <i class="bi bi-chevron-right chev"></i>
        </button>
        <ul class="submenu" id="sub-jur">
            <li><a href="#">Contratos</a></li>
            <li><a href="#">Políticas</a></li>
            <li><a href="#">LGPD</a></li>
        </ul>

        <button class="nav-item" data-tip="Dashboards" data-toggle-sub="sub-dash" aria-expanded="false">
            <div class="left"><i class="bi bi-columns-gap"></i><span class="label">Dashboards</span></div>
            <i class="bi bi-chevron-right chev"></i>
        </button>
        <ul class="submenu" id="sub-dash">
            <li><a href="#">Executivo</a></li>
            <li><a href="#">Operacional</a></li>
            <li><a href="#">Power BI</a></li>
        </ul>

        <button class="nav-item" data-tip="Documentos" data-toggle-sub="sub-doc" aria-expanded="false">
            <div class="left"><i class="bi bi-file-earmark"></i><span class="label">Documentos</span></div>
            <i class="bi bi-chevron-right chev"></i>
        </button>
        <ul class="submenu" id="sub-doc">
            <li><a href="#">Manuais</a></li>
            <li><a href="#">Modelos</a></li>
            <li><a href="#">Procedimentos</a></li>
        </ul>

        <button class="nav-item" data-tip="Central Colaborativa" data-toggle-sub="sub-col" aria-expanded="false">
            <div class="left"><i class="bi bi-collection"></i><span class="label">Central Colaborativa</span>
            </div>
            <i class="bi bi-chevron-right chev"></i>
        </button>
        <ul class="submenu" id="sub-col">
            <li><a href="#">Wiki</a></li>
            <li><a href="#">Fóruns</a></li>
            <li><a href="#">Times</a></li>
        </ul>

        <button class="nav-item" data-tip="Favoritos">
            <div class="left"><i class="bi bi-star"></i><span class="label">Favoritos</span></div>
        </button>
        <button class="nav-item" data-tip="Configurações" data-toggle-sub="sub-cfg" aria-expanded="false">
            <div class="left"><i class="bi bi-gear"></i><span class="label">Configurações</span></div>
            <i class="bi bi-chevron-right chev"></i>
        </button>
        <ul class="submenu" id="sub-cfg">
            <li><a href="#">Perfil</a></li>
            <li><a href="#">Preferências</a></li>
            <li><a href="#">Permissões</a></li>
        </ul>

        <div class="user-card">
            <img src="https://i.pravatar.cc/80?img=12" alt="">
            <div class="grow">
                <div class="name">John Doe</div>
                <div class="role">Administrador</div>
            </div>
            <i class="bi bi-chevron-down chev"></i>
        </div>
    </aside>

    <main class="main">
        <div class="hero-bg"></div>

        <div class="topbar">
            <button class="mobile-toggle" id="mobileToggle" aria-label="Abrir menu">
                <i class="bi bi-list"></i>
            </button>
            <div class="search">
                <i class="bi bi-search"></i>
                <input placeholder="Buscar na intranet...">
            </div>
            <div class="top-actions">
                <span class="ic"><i class="bi bi-bell"></i></span>
                <span class="ic"><i class="bi bi-chat"></i></span>
                <span class="ic"><i class="bi bi-bell-fill"></i><span class="dot">5</span></span>
                <span class="ic"><i class="bi bi-calendar3"></i></span>
                <span class="ic"><i class="bi bi-star"></i></span>
                <span class="ic"><i class="bi bi-lightbulb"></i></span>
            </div>
        </div>

        <div class="welcome">
            <h1>Bem-vindo de volta, John! 👋</h1>
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
                        <div class="ico" style="color:var(--red)"><i class="bi bi-exclamation-octagon"></i></div>
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
                            <div class="lg"><span class="dot" style="background:var(--red)"></span> Alta
                                &nbsp; <strong>28 (22%)</strong></div>
                            <div class="lg"><span class="dot" style="background:#cfd1d6"></span> Média &nbsp;
                                <strong>58 (45%)</strong></div>
                            <div class="lg"><span class="dot" style="background:#4a4d55"></span> Baixa &nbsp;
                                <strong>42 (33%)</strong></div>
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
                    <div class="text-end"><span class="ver-todos">Ver todos</span></div>
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
                    <div class="text-end mt-2"><span class="ver-todos">Ver todos</span></div>
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
                    <div class="text-end mt-2"><span class="ver-todos">Ver agenda</span></div>
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
                    <div class="text-end mt-2"><span class="ver-todos">Ver todos</span></div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const mobileToggle = document.getElementById('mobileToggle');
        const collapseBtn = document.getElementById('collapseBtn');

        // Mobile open/close
        mobileToggle.addEventListener('click', () => {
            sidebar.classList.add('open');
            overlay.classList.add('show');
        });
        overlay.addEventListener('click', () => {
            sidebar.classList.remove('open');
            overlay.classList.remove('show');
        });

        // Desktop collapse (icons only)
        collapseBtn.addEventListener('click', () => {
            document.body.classList.toggle('sidebar-collapsed');
            sidebar.classList.toggle('collapsed');
            // close all submenus when collapsing
            if (sidebar.classList.contains('collapsed')) {
                document.querySelectorAll('.submenu.open').forEach(s => s.classList.remove('open'));
                document.querySelectorAll('[aria-expanded="true"]').forEach(b => b.setAttribute('aria-expanded',
                    'false'));
            }
        });

        // Submenus
        document.querySelectorAll('[data-toggle-sub]').forEach(btn => {
            btn.addEventListener('click', (e) => {
                if (sidebar.classList.contains('collapsed')) return;
                const id = btn.getAttribute('data-toggle-sub');
                const sub = document.getElementById(id);
                const open = sub.classList.toggle('open');
                btn.setAttribute('aria-expanded', open ? 'true' : 'false');
            });
        });

        // Close mobile sidebar on link click
        document.querySelectorAll('.submenu a').forEach(a => {
            a.addEventListener('click', () => {
                if (window.innerWidth < 992) {
                    sidebar.classList.remove('open');
                    overlay.classList.remove('show');
                }
            });
        });
    </script>
</body>

</html>
