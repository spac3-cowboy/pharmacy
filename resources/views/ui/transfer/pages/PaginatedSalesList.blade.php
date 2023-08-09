@extends("Layout.MainLayout")



@section("title", "Sales")

@section("main")
    <div class="card shadow-none border">
        <div class="card-header bg-pitla-blue d-flex justify-content-between">
            <span>Transfer History</span>
        </div>
        <div class="card-body p-1 bordered">
            @include("ui.transfer.widgets.TablePaginatedTransferList")
        </div>
    </div>
@endsection


