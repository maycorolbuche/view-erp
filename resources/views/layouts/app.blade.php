<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>@yield('title')
        @if (!empty(trim($__env->yieldContent('title'))))
            ::
        @endif View FS
    </title>

    @include('layouts.partials.meta')
    @include('layouts.partials.css')

</head>


<body class="admin-elements-page" data-spy="scroll" data-target="#nav-spy" data-offset="300">
    <div id="main">
        @include('layouts.partials.header')
        @include('layouts.partials.sidebar')

        <!-- Start: Content-Wrapper -->
        <section id="content_wrapper">
            @include('layouts.partials.topbar-systems')
            @include('layouts.partials.topbar', [
                'breadcrumb' => View::getSection('breadcrumb'),
                'bt_right' => !empty(trim($__env->yieldContent('right'))),
            ])

            <section id="content" class="table-layout animated fadeIn">
                @yield('content')
            </section>

        </section>

        @if (!empty(trim($__env->yieldContent('right'))))
            <aside id="sidebar_right" class="nano">
                <div class="sidebar_right_content nano-content">
                    <div class="tab-block sidebar-block br-n">
                        @yield('right')
                    </div>
                </div>
            </aside>
        @endif
    </div>

    <div id="loading-overlay">
        <div id="loading-spinner"></div>
    </div>

    @include('layouts.partials.scripts')
    @stack('scripts')

</body>

</html>
