<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-sidebar="dark"
    data-sidebar-size="lg" data-preloader="disable" data-theme="default" data-bs-theme="light">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') - {{ $settings->where('key', 'site_name')->first()->value ?? 'Laravel' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Layout config Js -->
    <script src="{{ asset('assets/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css">
    <!-- custom Css-->
    <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css">
    <!-- extra css-->
    <link href="{{ asset('assets/css/extra-css.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/cdn/datatables/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
    <script src="{{ asset('assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('assets/libs/toastr/toastr.min.css') }}">
    @yield('vendor-css')
    @yield('page-css')
</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <!-- ========== App Menu ========== -->
        @include('layouts.includes.sidebar')
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>


        @include('layouts.includes.topbar')


        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content" id="ajaxresult" style="margin-top: 90px; padding: 0 16px;">
            @yield('content')
        </div>
        <!-- end main content-->

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <script>
                            document.write(new Date().getFullYear())
                        </script>
                        © Koormal.
                        <a href="https://themesbrand.com/steex/layouts/dashboard-crm.html" target="_blank"> steex</a>
                    </div>
                </div>
            </div>
        </footer>

    </div>
    <!-- END layout-wrapper -->

    <!--start back-to-top-->
    <button class="btn btn-dark btn-icon" id="back-to-top">
        <i class="bi bi-caret-up fs-3xl"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>




    <!-- JAVASCRIPT -->

    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <!-- App js -->
    {{-- public/assets/cdn/datatables/jquery.dataTables.min.js --}}

    <script src="{{ asset('assets/js/app.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/plugins.js') }}"></script> --}}
    <script src="{{ asset('assets/libs/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/cdn/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/cdn/datatables/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>

    {{-- Get withErrors --}}
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                notify('error', "{{ $error }}");
            </script>
        @endforeach
    @endif

    <script>
        @if (Session::has('success'))
            notify('success', "{{ session('success') }}");
        @elseif (Session::has('error'))
            notify('error', "{{ Session::get('error') }}");
        @elseif (Session::has('warning'))
            notify('warning', "{{ Session::get('warning') }}");
        @elseif (Session::has('info'))
            notify('info', "{{ Session::get('info') }}");
        @endif

        @foreach (session('toasts', collect())->toArray() as $toast)
            const options = {
                title: '{{ $toast['title'] ?? '' }}',
                message: '{{ $toast['message'] ?? 'No message provided' }}',
                position: '{{ $toast['position'] ?? 'topRight' }}',
            };
            show('{{ $toast['type'] ?? 'info' }}', options);
        @endforeach

        function notify(type, msg, position = 'topRight') {
            toastr[type](msg);
        }

        function show(type, options) {
            if (['info', 'success', 'warning', 'error'].includes(type)) {
                toastr[type](options);
            } else {
                toastr.show(options);
            }
        }

        $(document).ready(function() {
            $("[data-choices]").each(function() {
                new Choices(this);
            });

            function reinitializeChoices() {
                $("[data-choices]").each(function() {
                    new Choices(this);
                });
            }
        });
    </script>

    @yield('vendor-script')
    @yield('page-script')
</body>

</html>
