@extends("Layout.MainLayout")



@section("title", "New Purchases")

@section("main")
    @include("ui.purchase.widgets.FormCreatePurchase")
@endsection

@section("styles")
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section("scripts")
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection