<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>@yield('title')
        @if (!empty(trim($__env->yieldContent('title'))))
            ::
        @endif View Informática
    </title>

    <style>
        body {
            font-family: "Open Sans", Helvetica, Arial, sans-serif;
            font-size: 13px;
            font-weight: 400;
            line-height: 1.5;
            color: #000;
            background: $FFF;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }

        blockquote {
            padding: 5px 0 5px 15px;
            margin: 0;
            border-left: 3px solid #AAA;
        }
    </style>
</head>


<body>
    @yield('content')
</body>

</html>
