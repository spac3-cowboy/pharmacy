<!DOCTYPE html>
<html lang="en">


<!-- sp.ac3_cowboyicons-mdi time log Thu, 08 Jun 2023 03:57:30 GMT -->
<head>
    <meta charset="utf-8" />
    <title>Material Design Icons | Hyper - Responsive Bootstrap 5 Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('/assets/images/title.ico') }}">


    <!-- Plugin css -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/daterangepicker/daterangepicker.css') }}">
    <link href="{{ asset('assets/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css"/>

    <!-- Datatable css -->
    <link href="{{ asset('assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Theme Config Js -->
    <script src="{{ asset('assets/js/hyper-config.js') }}"></script>

    <!-- App css -->
    <link href="{{ asset('assets/css/app-saas.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />


    <!---------------------- Custom CSS -------------------->
    <link href="{{ asset('/assets/css/custom.css') }}" rel="stylesheet" type="text/css" />

    @yield("styles")

</head>

<body>
<!-- Begin page -->
<div class="wrapper">


    <!-- ========== Topbar Start ========== -->
    @include("Layout.Topbar")
    <!-- ========== Topbar End ========== -->

    <!-- ========== Left Sidebar Start ========== -->
    @include("Layout.LeftSidebar")
    <!-- ========== Left Sidebar End ========== -->

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
        <div class="content mt-2">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-11">
                        @yield("main")
                    </div>
                </div>
            </div>
        </div> <!-- content -->

        <!-- Footer Start -->
        @include("Layout.Footer")
        <!-- end Footer -->

    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

</div>
<!-- END wrapper -->

<!-- Vendor js -->
<script src="{{ asset('assets/js/vendor.min.js') }}"></script>

<!-- MDI Icons Demo js -->
<script src="{{ assert('assets/js/pages/demo.materialdesignicons.js') }}"></script>

<!-- Daterangepicker js -->
<script src="{{ asset('assets/vendor/daterangepicker/moment.min.js') }}"></script>
<script src="{{ asset('assets/vendor/daterangepicker/daterangepicker.js') }}"></script>


<!-- Vector Map js -->
<script src="{{ asset('assets/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('assets/vendor/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js') }}"></script>


<!-- App js -->
<script src="{{ asset('assets/js/app.min.js') }}"></script>



<script src="{{ asset('assets/js/sweetalert2@11.js') }}"></script>



@yield("scripts")


</body>

<!-- sp.ac3_cowboyicons-mdi time log Thu, 08 Jun 2023 03:57:30 GMT -->
</html>

