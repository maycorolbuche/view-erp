<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>@yield('title')
        @if (!empty(trim($__env->yieldContent('title'))))
            ::
        @endif View Informática
    </title>

    @include('layouts.partials.meta')


    <!-- Admin Forms CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-tools/admin-forms/css/admin-forms.css') }}">
</head>


<body class="external-page sb-l-c sb-r-c">

    <!-- Start: Main -->
    <div id="main" class="animated fadeIn">

        <!-- Start: Content-Wrapper -->
        <section id="content_wrapper">

            <!-- begin canvas animation bg -->
            <div id="canvas-wrapper">
                <canvas id="demo-canvas"></canvas>
            </div>

            <!-- Begin: Content -->
            <section id="content">
                <div class="admin-form theme-info" style="max-width: @yield('width', 500)px;">

                    <div class="row mb15 table-layout">

                        <div class="col-xs-6 va-m pln">
                            <a href="{{ route('home') }}">
                                <img src="{{ asset('assets/img/logos/logo-white.png') }}" style="height: 50px;">
                            </a>
                        </div>

                        <div class="col-xs-6 text-right va-b pr5">
                            <div class="login-links">
                                @yield('header-links')
                            </div>
                        </div>

                    </div>

                    <div class="panel panel-info mt10 br-n">
                        @yield('content')
                    </div>
                </div>
            </section>
            <!-- End: Content -->

        </section>
        <!-- End: Content-Wrapper -->

    </div>
    <!-- End: Main -->


    @include('layouts.partials.scripts')

    <script type="text/javascript" src="{{ asset('assets/js/pages/login/EasePack.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/pages/login/TweenLite.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/pages/login/login.js') }}"></script>

    <script type="text/javascript">
        CanvasBG.init({
            Loc: {
                x: window.innerWidth / 2,
                y: window.innerHeight / 3.3
            },
        });
    </script>

    @yield('scripts')

</body>

</html>
