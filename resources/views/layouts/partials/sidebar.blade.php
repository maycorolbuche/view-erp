<aside id="sidebar_left" class="nano nano-primary affix">
    <div class="nano-content">

        <ul class="nav sidebar-menu">
            <li class="sidebar-label pt20">Início</li>
            <li>
                <a href="{{ route('dashboard') }}">
                    <span class="glyphicons glyphicons-home"></span>
                    <span class="sidebar-title">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-label pt20">Menu</li>
            @php
                $current_route = explode('.', Route::currentRouteName() ?? '');
                $open = '';
            @endphp
            @foreach (request('__permissions') as $group_key => $group)
                <li data-id='{{ $group_key }}'>
                    <a class="accordion-toggle" href="javascript:">
                        <span class="{{ $group['icon'] }}"></span>
                        <span class="sidebar-title">{{ $group['label'] }}</span>
                        <span class="caret"></span>
                    </a>
                    <ul class="nav sub-nav">
                        @foreach ($group['items'] as $item)
                            @if ($item['route']['name'] == $current_route[0])
                                @php
                                    $open = $group_key;
                                @endphp
                            @endif
                            <li class="{{ $item['route']['name'] == $current_route[0] ? 'active' : '' }}">
                                <a href="{{ route($item['route']['name']) }}">
                                    <span class="{{ $item['route']['icon'] }}"></span>
                                    {{ $item['route']['label'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach

            @if (count(auth()->user()->load('systems')->systems) > 1)
                <li class="sidebar-label pt15">Sistemas</li>
                @foreach (auth()->user()->load('systems')->systems as $system)
                    <li>
                        <a href="{{ url('/' . $system->slug) }}">
                            <span class="{{ $system['icon'] }}"></span>
                            <span class="sidebar-title">{{ $system['name'] }}</span>
                        </a>
                    </li>
                @endforeach
            @endif
        </ul>
        <div class="sidebar-toggle-mini">
            <a href="javascript:">
                <span class="fa fa-sign-out-alt"></span>
            </a>
        </div>
    </div>
</aside>

@if ($open != '')
    @push('scripts')
        <script>
            $(document).ready(function() {
                $("[data-id='{{ $open }}']").addClass('active')
                    .find('a.accordion-toggle')
                    .addClass('menu-open');
            });
        </script>
    @endpush
@endif
