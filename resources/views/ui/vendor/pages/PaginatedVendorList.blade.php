@extends("Layout.MainLayout")



@section("title", "Vendors")

@section("main")
    <div class="card shadow-none border">
        <div class="card-header bg-pitla-blue d-flex justify-content-between">
            <span>Vendor List</span>
        </div>
        <div class="card-body  p-1 bordered">
            @include("ui.vendor.widgets.TablePaginatedVendorList")
        </div>
    </div>
@endsection


