@if (count(auth()->user()->load('systems')->systems) > 1)
    <div id="topbar-dropmenu">
        <div class="topbar-menu row">
            @foreach (auth()->user()->load('systems')->systems as $system)
                <div class="col-xs-4 col-sm-2">
                    <a href="{{ url('/' . $system->slug) }}" class="metro-tile bg-success">
                        <span class="metro-icon {{ $system['icon'] }}"></span>
                        <p class="metro-title">{{ $system['name'] }}</p>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endif
