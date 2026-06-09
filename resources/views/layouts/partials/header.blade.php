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
            <span class="badge text-bg-warning">
                {{ env('APP_ENV') }}
            </span>
        @endif
        @if (env('APP_DEBUG') == '1')
            <span class="badge text-bg-danger">
                debug
            </span>
        @endif

        <x-dropdown icon="calendar3" header-title="Eventos">
            <x-dropdown.item>Evento 1</x-dropdown.item>
            <x-dropdown.item>Evento 2</x-dropdown.item>
            <x-dropdown.item>Evento 3</x-dropdown.item>
        </x-dropdown>

        <x-dropdown icon="bell" header-title="Notificações" count="5">
            <x-dropdown.item>Notificação 1</x-dropdown.item>
            <x-dropdown.item>Notificação 2</x-dropdown.item>
            <x-dropdown.item>Notificação 3</x-dropdown.item>
        </x-dropdown>

        <div class="dropdown">
            <x-dropdown>
                <x-slot:trigger>
                    <x-avatar initials="{{ auth()->user()->initials }}" />
                </x-slot:trigger>
                <x-dropdown.item icon="lock" href="{{ route('me-password-change') }}">Alterar senha</x-dropdown.item>
                <x-dropdown.item icon="check2-circle" count="{{ request('__count_authorization') }}"
                    href="{{ route('me-authorizations') }}">
                    Autorizações
                </x-dropdown.item>
                <x-dropdown.item icon="database" href="{{ route('me-batches') }}">Lotes</x-dropdown.item>
                <x-dropdown.item icon="box-arrow-right" type="danger"
                    href="{{ route('logout') }}">Desconectar</x-dropdown.item>
            </x-dropdown>

        </div>
    </div>
</nav>
