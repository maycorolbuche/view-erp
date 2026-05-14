<nav class="navbar topbar">
    <button class="mobile-toggle" id="mobileToggle" aria-label="Abrir menu">
        <i class="bi bi-list"></i>
    </button>

    <div class="search">
        <i class="bi bi-search"></i>
        <input placeholder="Buscar na intranet...">
    </div>

    <div class="top-actions">
        @if (env('APP_ENV') != 'production')
            <span class="badge bg-warning">
                {{ env('APP_ENV') }}
            </span>
        @endif
        @if (env('APP_DEBUG') == '1')
            <span class="badge bg-danger">
                debug
            </span>
        @endif

        <span class="ic"><i class="bi bi-bell"></i></span>
        <span class="ic"><i class="bi bi-chat"></i></span>
        <span class="ic"><i class="bi bi-bell-fill"></i><span class="dot">5</span></span>
        <span class="ic"><i class="bi bi-calendar3"></i></span>
        <span class="ic"><i class="bi bi-star"></i></span>
        <span class="ic"><i class="bi bi-lightbulb"></i></span>

        <div class="dropdown">
            <a href="javascript:void(0)" class="dropdown-toggle user-menu" data-bs-toggle="dropdown"
                aria-expanded="false">

                <div class="avatar">
                    {{ auth()->user()->initials }}
                    A
                </div>
            </a>

            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                <li>
                    <a class="dropdown-item" href="{{ route('me-password-change') }}">
                        <i class="bi bi-lock me-2"></i>
                        Alterar senha
                    </a>
                </li>
                <li>
                    <a class="dropdown-item d-flex justify-content-between align-items-center"
                        href="{{ route('me-authorizations') }}">
                        <span>
                            <i class="bi bi-check2-circle me-2"></i>
                            Autorizações
                        </span>
                        @if (request('__count_authorization') > 0)
                            <span class="badge bg-warning text-dark">
                                {{ request('__count_authorization') }}
                            </span>
                        @endif
                    </a>
                </li>

                <li>
                    <a class="dropdown-item" href="{{ route('me-batches') }}">
                        <i class="bi bi-database me-2"></i>
                        Lotes
                    </a>
                </li>

                <li>
                    <hr class="dropdown-divider">
                </li>

                <li>
                    <a class="dropdown-item text-danger" href="{{ route('logout') }}">

                        <i class="bi bi-box-arrow-right me-2"></i>
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    .user-menu {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        color: inherit;
        padding: 8px 14px;
        border-radius: 14px;
        transition: .2s;
    }

    .user-menu:hover {
        background: rgba(255, 255, 255, .06);
    }

    .avatar {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 12px;
        flex-shrink: 0;
    }


    .dropdown-menu {
        min-width: 260px;
        border-radius: 16px;
        overflow: hidden;
        padding: 8px;
    }

    .dropdown-item {
        border-radius: 10px;
        padding: 10px 12px;
        transition: .15s;
    }

    .dropdown-item:hover {
        background: #f3f4f6;
    }

    .dropdown-header {
        font-weight: 700;
        padding: 12px;
    }
</style>
