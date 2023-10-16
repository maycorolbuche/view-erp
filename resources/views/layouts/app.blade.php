<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>@yield('title')
        @if (!empty(trim($__env->yieldContent('title'))))
            ::
        @endif View Informática
    </title>
    <meta name="keywords" content="HTML5 Bootstrap 3 Admin Template UI Theme" />
    <meta name="description" content="AdminDesigns - SHARED ON THEMELOCK.COM">
    <meta name="author" content="AdminDesigns">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.ico') }}">

    <!-- Font CSS (Via CDN) -->
    <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800'>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300">

    <!-- Theme CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/skin/default_skin/css/theme.css') }}">

    <!-- Admin Forms CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin-tools/admin-forms/css/admin-forms.css') }}">

</head>


<body class="admin-elements-page" data-spy="scroll" data-target="#nav-spy" data-offset="300">

    <div id="main">
        @include('layouts.header')
        @include('layouts.sidebar')

        <!-- Start: Content-Wrapper -->
        <section id="content_wrapper">

            @include('layouts.topbar-systems')
            @include('layouts.topbar')

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

    @include('layouts.scripts')
    @yield('scripts')

</body>

</html>
