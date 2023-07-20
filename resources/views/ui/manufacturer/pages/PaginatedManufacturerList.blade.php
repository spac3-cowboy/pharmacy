@extends("Layout.MainLayout")



@section("title", "Manufacturers")

@section("main")
    <div class="card shadow-none border">
        <div class="card-header bg-pitla-blue d-flex justify-content-between">
            <span>Manufacturer List</span>
        </div>
        <div class="card-body  p-1 bordered">
            @include("ui.manufacturer.widgets.TablePaginatedManufacturerList")
        </div>
    </div>
@endsection


