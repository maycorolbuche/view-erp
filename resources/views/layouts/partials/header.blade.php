<header class="navbar navbar-fixed-top bg-dark">
    <div class="navbar-branding">
        <a class="navbar-brand" href="{{ route('home') }}" style="width: calc(100% - 60px);">
            <img src="{{ asset('assets/img/logos/logo-white.png') }}"
                style="height: 100%;width: 100%;object-fit: contain;">
        </a>
        <span id="toggle_sidemenu_l" class="glyphicons glyphicons-show_lines"></span>
        <ul class="nav navbar-nav pull-right hidden">
            <li>
                <a href="javascript:" class="sidebar-menu-toggle">
                    <span class="octicon octicon-ruby fs20 mr10 pull-right "></span>
                </a>
            </li>
        </ul>
    </div>
    <ul class="nav navbar-nav navbar-right">
        @if (count(auth()->user()->load('systems')->systems) > 1)
            <li>
                <a class="topbar-menu-toggle" href="javascript:"
                    onclick="$('html, body').animate({ scrollTop: 0 }, 'fast');">
                    <span class="{{ request('__system')['icon'] }} fs16"></span>
                    &nbsp;
                    <span class="fw600">{{ request('__system')['name'] }}</span>
                </a>
            </li>
        @endif
        <li class="dropdown dropdown-item-slide">
            <a class="dropdown-toggle pl10 pr10" data-toggle="dropdown" href="javascript:">
                <span class="octicon octicon-radio-tower fs18"></span>
            </a>
            <ul class="dropdown-menu dropdown-hover dropdown-persist pn w350 bg-white animated animated-shorter fadeIn"
                role="menu">
                <li class="bg-light p8">
                    <span class="fw600 pl5 lh30"> Notifications</span>
                    <span class="label label-warning label-sm pull-right lh20 h-20 mt5 mr5">12</span>
                </li>
                <li class="p10 br-t item-1">
                    <div class="media">
                        <a class="media-left" href="javascript:"> <img src="{{ asset('assets/img/avatars/2.jpg') }}"
                                class="mw40" alt="holder-img"> </a>
                        <div class="media-body va-m">
                            <h5 class="media-heading mv5">Article <small class="text-muted">- 08/16/22</small>
                            </h5> Last Updated 36 days ago by
                            <a class="text-system" href="javascript:"> Max </a>
                        </div>
                    </div>
                </li>
                <li class="p10 br-t item-2">
                    <div class="media">
                        <a class="media-left" href="javascript:"> <img src="{{ asset('assets/img/avatars/3.jpg') }}"
                                class="mw40" alt="holder-img"> </a>
                        <div class="media-body va-m">
                            <h5 class="media-heading mv5">Article <small class="text-muted">- 08/16/22</small>
                            </h5> Last Updated 36 days ago by
                            <a class="text-system" href="javascript:"> Max </a>
                        </div>
                    </div>
                </li>
                <li class="p10 br-t item-3">
                    <div class="media">
                        <a class="media-left" href="javascript:"> <img src="{{ asset('assets/img/avatars/4.jpg') }}"
                                class="mw40" alt="holder-img"> </a>
                        <div class="media-body va-m">
                            <h5 class="media-heading mv5">Article <small class="text-muted">- 08/16/22</small>
                            </h5> Last Updated 36 days ago by
                            <a class="text-system" href="javascript:"> Max </a>
                        </div>
                    </div>
                </li>
                <li class="p10 br-t item-4">
                    <div class="media">
                        <a class="media-left" href="javascript:"> <img src="{{ asset('assets/img/avatars/5.jpg') }}"
                                class="mw40" alt="holder-img"> </a>
                        <div class="media-body va-m">
                            <h5 class="media-heading mv5">Article <small class="text-muted">- 08/16/22</small>
                            </h5> Last Updated 36 days ago by
                            <a class="text-system" href="javascript:"> Max </a>
                        </div>
                    </div>
                </li>
            </ul>
        </li>
        <li class="ph10 pv20 hidden-xs"> <i class="fa fa-circle text-tp fs8"></i>
        </li>
        <li class="dropdown">
            <a href="javascript:" class="dropdown-toggle fw600 p15"
                data-toggle="dropdown"style="display: flex;align-items: center;">
                <div class="initials mw30 br64 mr15">
                    {{ auth()->user()->initials }}
                </div>
                <span>{{ auth()->user()->short_name }}</span>
                <span class="caret caret-tp hidden-xs"></span>
            </a>
            <ul class="dropdown-menu dropdown-persist pn w250 bg-white" role="menu">
                <li class="of-h">
                    <a href="javascript:" class="fw600 p12 animated animated-short fadeInUp">
                        <span class="fa fa-envelope pr5"></span> Mensagens
                        <span class="pull-right lh20 h-20 label label-warning label-sm">2</span>
                    </a>
                </li>
                <li class="br-t of-h">
                    <a href="javascript:" class="fw600 p12 animated animated-short fadeInUp">
                        <span class="fa fa-user pr5"></span> Perfil
                        <span class="pull-right lh20 h-20 label label-warning label-sm">6</span>
                    </a>
                </li>
                <li class="br-t of-h">
                    <a href="javascript:" class="fw600 p12 animated animated-short fadeInDown">
                        <span class="fa fa-lock pr5"></span> Alterar Senha </a>
                </li>
                <li class="br-t of-h">
                    <a href="{{ route('logout') }}" class="fw600 p12 animated animated-short fadeInDown">
                        <span class="fa fa-power-off pr5"></span> Logout </a>
                </li>
            </ul>
        </li>
    </ul>
</header>
