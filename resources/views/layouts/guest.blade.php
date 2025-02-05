{{--<!DOCTYPE html>--}}
{{--<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">--}}
{{--    <head>--}}
{{--        <meta charset="utf-8">--}}
{{--        <meta name="viewport" content="width=device-width, initial-scale=1">--}}
{{--        <meta name="csrf-token" content="{{ csrf_token() }}">--}}

{{--        <title>{{ config('app.name', 'Laravel') }}</title>--}}

{{--        <!-- Fonts -->--}}
{{--        <link rel="preconnect" href="https://fonts.bunny.net">--}}
{{--        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />--}}

{{--        <!-- Scripts -->--}}
{{--        @vite(['resources/css/app.css', 'resources/js/app.js'])--}}

{{--        <!-- Styles -->--}}
{{--        @livewireStyles--}}
{{--    </head>--}}
{{--    <body>--}}
{{--        <div class="font-sans text-gray-900 dark:text-gray-100 antialiased">--}}
{{--            {{ $slot }}--}}
{{--        </div>--}}

{{--        @livewireScripts--}}
{{--    </body>--}}
{{--</html>--}}
    <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-layout-style="detached" data-sidebar="dark" data-sidebar-size="lg"
      data-preloader="disable" data-theme="modern" data-bs-theme="light">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}">

    <!-- Layout config Js -->
    <script src="{{asset('assets/js/layout.js')}}"></script>
    <!-- Bootstrap Css -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <!-- Icons Css -->
    <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="{{asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css">
    <!-- custom Css-->
    <link href="{{asset('assets/css/custom.min.css')}}" rel="stylesheet" type="text/css">

    @livewireStyles
</head>

<body>

<section
    class="auth-page-wrapper py-5 position-relative d-flex align-items-center justify-content-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            @yield('content')
        </div>
        <!--end row-->
    </div>
    <!--end container-->
</section>

<!-- JAVASCRIPT -->
<script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('assets/js/plugins.js')}}"></script>

<script src="{{asset('assets/js/pages/password-addon.init.js')}}"></script>

<!--Swiper slider js-->
<script src="{{asset('assets/libs/swiper/swiper-bundle.min.js')}}"></script>

<!-- swiper.init js -->
<script src="{{asset('assets/js/pages/swiper.init.js')}}"></script>
@livewireScripts
</body>

</html>


