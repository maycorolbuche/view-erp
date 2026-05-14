<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>@yield('title')
        @if (!empty(trim($__env->yieldContent('title'))))
            ::
        @endif View FS
    </title>

    @include('layouts.partials.meta')

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])

    @include('layouts.partials.css')
    @stack('styles')
</head>

<body>
    <div class="sidebar-overlay" id="overlay"></div>

    @include('layouts.partials.sidebar')


    <main class="main">
        <div class="hero-bg"></div>

        @include('layouts.partials.header')

        @yield('content')

    </main>

    <script></script>
</body>

</html>
