@extends("Layout.MainLayout")



@section("title", "New Purchases")

@section("main")
    @include("ui.purchase.widgets.FormCreatePurchase")
@endsection

@section("styles")
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        /* This rule targets the scrollbar itself */
        ::-webkit-scrollbar {
            width: 10px; /* Width of the scrollbar */
        }

        /* This rule targets the scrollbar track */
        ::-webkit-scrollbar-track {
            background-color: #f1f1f1; /* Color of the track */
        }

        /* This rule targets the scrollbar thumb */
        ::-webkit-scrollbar-thumb {
            background-color: #888; /* Color of the thumb */
            border-radius: 5px; /* Rounded corners */
        }

        /* This rule targets the scrollbar thumb when hovered */
        ::-webkit-scrollbar-thumb:hover {
            background-color: red; /* Color of the thumb on hover */
        }
        #table-container-div table {
            overflow: scroll !important;
        }

    </style>
@endsection

@section("scripts")
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection