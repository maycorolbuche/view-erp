<!-- Font CSS (Via CDN) -->
<link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800'>
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300">

<!-- Vendor CSS -->
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/plugins/magnific/magnific-popup.css') }}">

<!-- Theme CSS -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/skin/default_skin/css/theme.css') }}">

<!-- Datatables CSS -->
<link rel="stylesheet" type="text/css"
    href="{{ asset('vendor/plugins/datatables/media/css/dataTables.bootstrap.css') }}">

<!-- Datatables Editor CSS -->
<link rel="stylesheet" type="text/css"
    href="{{ asset('vendor/plugins/datatables/extensions/Editor/css/dataTables.editor.css') }}">

<!-- Page Plugins -->
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/plugins/telinput/intlTelInput.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/plugins/chosen/chosen.min.css') }}">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
    integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">


<style>
    /* demo page styles */
    body {
        min-height: initial;
    }

    .affix-pane.affix {
        top: 80px;
    }

    .admin-form .panel.heading-border:before,
    .admin-form .panel .heading-border:before {
        transition: all 0.7s ease;
    }

    .custom-nav-animation li {
        display: none;
    }

    .custom-nav-animation li.animated {
        display: block;
    }

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


    .topbar-right {
        display: flex;
        align-items: center;
    }

    @media (max-width: 500px) {
        .topbar-right .search-routes {
            display: none;
        }
    }

    .error-icon,
    .success-icon {
        display: none;
    }

    .has-error .error-icon,
    .has-success .success-icon {
        display: block;
    }

    .has-error em {
        color: #e9573f;
        font-size: 11px;
        font-style: normal;
    }

    ::placeholder {
        color: #BBB !important;
    }

    #loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #5f5f5f61;
        z-index: 9999;
    }

    #loading-spinner {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    table>thead>tr>th {
        font-weight: bold !important;
        background-color: #E9ECEF !important;
    }

    .nav.sidebar-menu {
        background-color: #30363e;
    }

    input.slug {
        text-transform: lowercase;
    }


    /* Input Group Merge Addon */
    .input-group-merge {
        display: block;
    }

    .input-group-merge .input-group-addon {
        position: absolute;
        top: 5px;
        left: 10px;
        border: 0;
        background: transparent;
        z-index: 3;
        font-size: 13px;
    }

    .input-group-merge .input-group-addon+input.form-control {
        display: block;
        float: none;
        padding-left: 60px;
    }

    /* Input Group Merge Addon - Sizes */
    .input-hero.input-group-merge .input-group-addon,
    .input-hero.input-group-merge input.form-control {
        font-size: 16px;
    }

    .input-hero.input-group-merge .input-group-addon {
        top: 12px;
        font-size: 18px;
    }

    .input-hero.input-group-merge input {
        border-left: 3px solid #4a89dc !important;
    }





    .chosen-single,
    .chosen-choices {
        display: block !important;
        width: 100% !important;
        font-size: 13px !important;
        color: #555555 !important;
        background-color: #ffffff !important;
        background-image: none !important;
        border: 1px solid #dddddd !important;
        border-radius: 0px !important;
        box-shadow: initial !important;
        min-height: 39px !important;
        padding-top: 6px !important;
        padding-left: 12px !important;
    }

    .chosen-single div {
        padding-top: 7px !important;
    }

    .chosen-single abbr {
        margin-top: 7px !important;
    }

    /*
    .chosen-container-multi .search-choice {
        color: #FFF !important;
        background: #6c9fe3 !important;
        margin-right: 8px !important;
        color: #FFF !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        border: 0 !important;
        border-radius: 1px !important;
        box-shadow: none !important;
    }
    */
</style>
