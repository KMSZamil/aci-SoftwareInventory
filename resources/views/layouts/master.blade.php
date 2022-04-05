<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('assets/images/z-white.png') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page_title')</title>
    <link rel="stylesheet" href="{{ asset('assets/vendors/core/core.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather-font/css/iconfont.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather-font/css/iconfont.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/demo_1/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link href="{{ asset('assets/vendors/sweetalert2/sweetalert2.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .table th,
        .table td {
            padding: 0.437rem 0.4687rem !important;
            border-top: 1px solid #e8ebf1;
        }

    </style>

    @stack('css')

</head>

<body class="sidebar-dark">
    <div class="main-wrapper">

        @include('layouts.sidebar')

        <div class="page-wrapper">

            @include('layouts.navbar')

            <div class="page-content">

                @yield('content')

            </div>

            @include('layouts.footer')

        </div>
    </div>

    <script src="{{ asset('assets/vendors/core/core.js') }}"></script>
    <script src="{{ asset('assets/js/template.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('assets/vendors/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/vendors/promise-polyfill/polyfill.min.js') }}"></script>
    <script type="text/javascript">
        var specialKeys = [];
        specialKeys.push(8); //Backspace
        $(function() {
            $('.numeric').bind("keypress", function(e) {
                var attr_id = $(this).attr('id'); //alert(attr_id);
                var keyCode = e.which ? e.which : e.keyCode
                //console.log(attr_id);
                var ret = ((keyCode >= 48 && keyCode <= 57 || keyCode == 46 || keyCode == 45) || specialKeys
                    .indexOf(keyCode) != -1);
                $(".error" + attr_id).css("display", ret ? "none" : "inline");
                return ret;
            });
            $('.numeric').bind("paste", function(e) {
                return false;
            });
            $(".numeric").bind("drop", function(e) {
                return false;
            });
        });
    </script>
    @stack('js')

</body>

</html>
