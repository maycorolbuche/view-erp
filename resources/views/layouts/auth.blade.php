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
    @stack('styles')

</head>


<body class="light-bg">
    @include('layouts.partials.overlays')

    <div class="container-fluid min-vh-100">
        <div class="row min-vh-100">

            <!-- Lado esquerdo -->
            <div class="col-lg-6 d-none d-lg-flex flex-column justify-content-between p-5">

                <!-- Logo -->
                <div>
                    <x-logo zoom="0.6" />
                </div>

                <div class="flex-fill">
                    @yield('side-card')
                </div>

            </div>

            <!-- Lado direito -->
            <div class="col-lg-6 d-flex align-items-center justify-content-center p-4">
                @yield('content')
            </div>

        </div>
    </div>

    @stack('scripts')

</body>

</html>
