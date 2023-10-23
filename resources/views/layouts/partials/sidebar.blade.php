<aside id="sidebar_left" class="nano nano-primary affix">
    <div class="nano-content">


        <ul class="nav sidebar-menu">
            <li class="sidebar-label pt20">Menu</li>
            @php
                $open = '';
            @endphp
            @foreach (request('__permissions') as $group_key => $group)
                <li data-id='{{ $group_key }}'>
                    <a class="accordion-toggle" href="#">
                        <span class="{{ $group['icon'] }}"></span>
                        <span class="sidebar-title">{{ $group['label'] }}</span>
                        <span class="caret"></span>
                    </a>
                    <ul class="nav sub-nav">
                        @foreach ($group['items'] as $item)
                            @if ($item['route']['uri'] == (request('__uri') ?? '') ? 'active' : '')
                                @php
                                    $open = $group_key;
                                @endphp
                            @endif
                            <li class="{{ $item['route']['uri'] == (request('__uri') ?? '') ? 'active' : '' }}">
                                <a href="{{ route($item['route']['name'], ['system' => request('__system_slug')]) }}">
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
                        <a href="{{ route('dashboard', ['system' => $system['slug']]) }}">
                            <span class="{{ $system['icon'] }}"></span>
                            <span class="sidebar-title">{{ $system['name'] }}</span>
                        </a>
                    </li>
                @endforeach
            @endif
        </ul>
        <div class="sidebar-toggle-mini">
            <a href="#">
                <span class="fa fa-sign-out"></span>
            </a>
        </div>
    </div>
</aside>

@if ($open != '')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelector("[data-id='{{ $open }}']")
                .classList.add('active');

            document.querySelector("[data-id='{{ $open }}']")
                .querySelector('a.accordion-toggle')
                .classList.add('menu-open');
        });
    </script>
@endif
