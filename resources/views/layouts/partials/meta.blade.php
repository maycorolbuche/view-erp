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

<style>
    .text-bold {
        font-weight: bold;
    }

    .initials {
        background: #2eaad8;
        padding: 5px;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: bold;
        font-size: 14px;
    }

    #content_wrapper {
        padding-top: 60px;
    }

    .breadcrumb>li.crumb-active>span {
        color: #555;
        font-size: 18px;
    }

    select+.btn-group,
    select+.btn-group button {
        width: 100%;
    }

    select+.btn-group button.dropdown-toggle {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .topbar-right {
        display: flex;
        align-items: center;
    }

    @media (max-width: 500px) {
        .topbar-right .search-routes {
            display: none;
        }
    }
</style>
