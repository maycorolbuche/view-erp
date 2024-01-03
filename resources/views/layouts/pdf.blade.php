<html>

<head>
    <title>@yield('title')
        @if (!empty(trim($__env->yieldContent('title'))))
            ::
        @endif View Informática
    </title>

    <style>
        @page {
            margin: 1cm 1cm;
        }

        header {
            position: fixed;
            top: -1cm;
            left: 0px;
            right: 0px;
            height: 50px;
        }

        footer {
            position: fixed;
            bottom: -1cm;
            left: 0px;
            right: 0px;
            height: 50px;
        }

        .pagenum:before {
            content: counter(page);
        }



        body {
            font-family: "Open Sans", Helvetica, Arial, sans-serif;
            font-size: 11px;
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

        h2 {
            font-weight: inherit;
        }

        .table th,
        .table td {
            padding: 5px 10px;
            border: 1px solid #000;
        }

        .table thead th,
        .table thead td {
            background-color: #BBB;
        }

        .table tbody tr:nth-child(even) {
            background-color: #DDD;
        }

        .table .text-right {
            text-align: right;
        }

        .table .text-center {
            text-align: center;
        }
    </style>
</head>


<body>
    @yield('content')
</body>

</html>
