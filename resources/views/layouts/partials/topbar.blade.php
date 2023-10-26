@php
    $breadcrumb = $breadcrumb ? json_decode(htmlspecialchars_decode($breadcrumb)) : [];
@endphp

<header id="topbar">
    <div class="topbar-left">
        <ol class="breadcrumb">
            <li class="crumb-icon">
                <a href="{{ route('dashboard', ['system' => request('__system')['slug']]) }}">
                    <span class="glyphicon glyphicon-home"></span>
                </a>
            </li>
            @foreach ($breadcrumb as $index => $item)
                @php
                    $item = json_decode(json_encode($item), true);
                    $type = $index <= 0 ? 'active' : ($index < count($breadcrumb) - 1 ? 'trail' : 'link');
                    $path = $item['uri'] ?? ($item['route'] ?? ($item['path'] ?? ''));
                    $icon = $item['icon'] ?? '';
                @endphp
                <li class="crumb-{{ $type }}">
                    @if ($index < count($breadcrumb) - 1 && $path != '')
                        <a href="{{ route($path, ['system' => request('__system')['slug']]) }}">
                            @if ($icon != '')
                                <span class="{{ $icon }}"></span>
                            @endif
                            {{ $item['label'] }}
                        </a>
                    @else
                        <span>
                            @if ($icon != '')
                                <span class="{{ $icon }}"></span>
                            @endif
                            {{ $item['label'] }}
                        </span>
                    @endif
                </li>
            @endforeach
        </ol>
    </div>
    <div class="topbar-right">
        <div style="width:300px;" class="search-routes">
            <select onchange="window.location.href = $(this).val()">
                <option></option>
                <option value="{{ route('dashboard') }}" {{ request('__uri') ?? '' == '' ? 'selected' : '' }}>
                    Buscar Menu...
                </option>
                @foreach (request('__permissions') as $group_key => $group)
                    <optgroup label="{{ $group['label'] }}">
                        @foreach ($group['items'] as $item)
                            <option value="{{ route($item['route']['name']) }}"
                                {{ $item['route']['uri'] == (request('__uri') ?? '') ? 'selected' : '' }}>
                                {{ $item['route']['label'] }}
                            </option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
        </div>

        <div class="ml15 ib va-m" id="toggle_sidemenu_r">
            @if ($bt_right ?? false)
                <a href="javascript:" class="pl5">
                    <i class="fa fa-sign-in fs22 text-primary"></i>
                </a>
            @endif
        </div>
    </div>
</header>
