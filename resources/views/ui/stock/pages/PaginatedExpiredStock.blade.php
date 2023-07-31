@extends("Layout.MainLayout")



@section("title", "In Stock")

@section("main")
    <div class="card shadow-none border">
        <div class="card-header bg-pitla-blue d-flex justify-content-between">
            <span>Expired Stock Medicine List</span>
        </div>
        <div class="card-body p-1 bordered">
            @include("ui.stock.widgets.TablePaginatedExpiredStock")
        </div>
    </div>
@endsection


