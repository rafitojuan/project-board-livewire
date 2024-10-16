<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title>{{ $title ?? 'Page Title' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Dashboard EPI" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico') }}">
    @include('layouts.head-css')
    @livewireStyles
</head>

@section('body')

    <body data-sidebar="dark" data-layout-mode="light">
    @show
    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('layouts.topbar')
        @include('layouts.sidebar')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    {{ $slot }}
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            @include('layouts.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    @include('layouts.right-sidebar')
    <!-- /Right-bar -->

    @livewireScripts
    @include('layouts.vendor-scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-livewire-alert::scripts />
    <!-- JAVASCRIPT -->
</body>

</html>
