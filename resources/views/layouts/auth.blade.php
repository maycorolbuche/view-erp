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
                <div class="admin-form theme-info" id="login1" style="max-width: 500px;">
                    @yield('content')
                </div>
            </section>
            <!-- End: Content -->

        </section>
        <!-- End: Content-Wrapper -->

    </div>
    <!-- End: Main -->


    @include('layouts.partials.scripts')

    <script type="text/javascript" src="assets/js/pages/login/EasePack.min.js"></script>
    <script type="text/javascript" src="assets/js/pages/login/TweenLite.min.js"></script>
    <script type="text/javascript" src="assets/js/pages/login/login.js"></script>

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
