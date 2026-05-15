<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>@yield('title')
        @if (!empty(trim($__env->yieldContent('title'))))
            ::
        @endif View FS
    </title>


</head>


<body style="background: #FFF !important;">
    <section id="content" class="table-layout animated fadeIn">
        @yield('content')
    </section>


    @include('layouts.partials.scripts')
    @stack('scripts')

    <script>
        function sendParams(params) {
            window.parent.postMessage({
                type: 'IFRAME_CALLBACK',
                payload: params
            }, '*');
        }
    </script>
</body>

</html>
