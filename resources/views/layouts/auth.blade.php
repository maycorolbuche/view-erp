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


<body class="external-page sb-l-c sb-r-c">

    <div class="container-fluid min-vh-100">
        <div class="row min-vh-100">

            <!-- Lado esquerdo -->
            <div class="col-lg-6 d-none d-lg-flex flex-column justify-content-between p-5">

                <!-- Logo -->
                <div>
                    <h2 class="fw-bold mb-0">
                        VIEW
                        <small class="fw-light">INTRANET</small>
                    </h2>
                </div>

                @yield('side-card')

            </div>

            <!-- Lado direito -->
            <div class="col-lg-6 d-flex align-items-center justify-content-center p-4">
                <div>
                    @yield('content')
                </div>
            </div>

        </div>
    </div>

    @stack('scripts')

</body>

</html>
