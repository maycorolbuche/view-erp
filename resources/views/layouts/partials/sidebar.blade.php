<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="brand">
            <div class="brand-text">
                <span class="logo">VIEW</span><span class="sub">INTRANET</span>
            </div>
            <button class="collapse-btn d-none d-lg-flex" id="collapseBtn" title="Recolher menu">
                <i class="bi bi-list"></i>
            </button>
        </div>

        <div class="user-card">
            <img src="https://i.pravatar.cc/80?img=12" alt="">
            <div class="grow">
                <div class="name">John Doe</div>
                <div class="role">Administrador</div>
            </div>
            <i class="bi bi-chevron-down chev"></i>
        </div>
    </div>

    <div class="sidebar-body">
        @php
            $current_route = explode('.', Route::currentRouteName() ?? '')[0];
            //dd($current_route);
        @endphp

        <ul class="list-unstyled ps-0">
            <li class="mb-1">
                <a class="nav-item {{ $current_route == 'dashboard' ? 'active' : '' }}" data-tip="Home"
                    href="{{ route('dashboard') }}">
                    <div class="left">
                        <i class="bi bi-columns-gap"></i>
                        <span class="label">Dashboard</span>
                    </div>
                </a>
            </li>

            @foreach (request('__permissions') as $group_key => $group)
                @php
                    $is_active_group = collect($group['items'])->contains(function ($item) use ($current_route) {
                        return $item['route']['name'] == $current_route;
                    });
                @endphp
                <li class="mb-1">
                    <button class="nav-item {{ $is_active_group ? 'active' : '' }}" data-tip="{{ $group['label'] }}"
                        data-bs-toggle="collapse" data-bs-target="#sub-{{ $group_key }}-collapse"
                        aria-expanded="{{ $is_active_group ? 'true' : 'false' }}">
                        <div class="left">
                            <i class="{{ $group['icon'] }}"></i>
                            <span class="label">{{ $group['label'] }}</span>
                        </div>
                        <i class="bi bi-chevron-right chev"></i>
                    </button>
                    <div class="collapse {{ $is_active_group ? 'show' : '' }}" id="sub-{{ $group_key }}-collapse"
                        style="">
                        <ul class="submenu btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            @foreach ($group['items'] as $item)
                                <li class="{{ $item['route']['name'] == $current_route ? 'active' : '' }}">
                                    <a href="{{ route($item['route']['name']) }}">
                                        <span class="label">{{ $item['route']['label'] }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
            @endforeach

        </ul>
    </div>

</aside>
