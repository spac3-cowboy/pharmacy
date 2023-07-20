@extends("Layout.MainLayout")



@section("title", "Purchases")

@section("main")
    <div class="card shadow-none border">
        <div class="card-header bg-pitla-blue d-flex justify-content-between">
            <span>Purchase List</span>
        </div>
        <div class="card-body p-1 bordered">
            @include("ui.purchase.widgets.TablePaginatedPurchase")
        </div>
    </div>
@endsection


