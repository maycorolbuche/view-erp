<!DOCTYPE html>
<html>

<head>
    <title>@yield('title')
        @if (!empty(trim($__env->yieldContent('title'))))
            ::
        @endif View Informática
    </title>

    @include('layouts.partials.meta')

</head>


<body class="admin-elements-page" data-spy="scroll" data-target="#nav-spy" data-offset="300">

    <div id="main">
        @include('layouts.partials.header')
        @include('layouts.partials.sidebar')

        <!-- Start: Content-Wrapper -->
        <section id="content_wrapper">

            @include('layouts.partials.topbar-systems')
            @include('layouts.partials.topbar')

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

    @include('layouts.partials.scripts')
    @yield('scripts')

</body>

</html>
