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
            <button class="btn btn-secondary dropdown-toggle d-flex align-items-center" type="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <div class="avatar">
                    {{ auth()->user()->initials }}
                    A
                </div>
            </button>
            <ul class="dropdown-menu">
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
