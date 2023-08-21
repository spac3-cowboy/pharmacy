<!DOCTYPE html>
<html lang="en">


<!-- sp.ac3_cowboyicons-mdi time log Thu, 08 Jun 2023 03:57:30 GMT -->
<head>
    <meta charset="utf-8" />
    <title>@yield("title")</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('/assets/images/title.ico') }}">


    <!-- Plugin css -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/daterangepicker/daterangepicker.css') }}">
    <link href="{{ asset('assets/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css"/>

    <!-- Datatable css -->
    <link href="{{ asset('assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">

    <!-- Theme Config Js -->
    <script src="{{ asset('assets/js/hyper-config.js') }}"></script>

    <!-- App css -->
    <link href="{{ asset('assets/css/app-saas.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />


    <!---------------------- Custom CSS -------------------->
    <link href="{{ asset('/assets/css/custom.css') }}" rel="stylesheet" type="text/css" />


    <style type="text/css">
        .select2-container {
            height: 52px!important;
        }
        .select2-container--default .select2-selection--single {
            border: 2px solid #f0f1f3!important;
        }
        .select2-container .select2-selection--single {
            height: 54px!important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 54px!important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            line-height: 54px!important;
            height: 54px!important;
        }
        .select2-container--default .select2-selection--single {
            border: 2px solid #dee2e6 !important;
        }
    </style>
    @yield("styles")



</head>

<body>

<!-- Overlay -->
<div id="overlay" class="hide">
    <div id="loader">

    </div>
</div>
<!-- Overlay End -->

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
                    <div class="col-lg-11 col-sm-12">
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

<!-- Datatable js -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>

<!-- App js -->
<script src="{{ asset('assets/js/app.min.js') }}"></script>



<script src="{{ asset('assets/js/sweetalert2@11.js') }}"></script>


<!-- Common Script All Across the App js -->
<script src="{{ asset('assets/js/common.js') }}"></script>


@yield("scripts")




</body>

<!-- sp.ac3_cowboyicons-mdi time log Thu, 08 Jun 2023 03:57:30 GMT -->
</html>

