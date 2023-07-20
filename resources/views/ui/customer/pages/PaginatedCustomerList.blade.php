@extends("Layout.MainLayout")



@section("title", "Customers")

@section("main")
    <div class="card">
        <div class="card-header bg-pitla-blue">
            Customer List
        </div>
        <div class="card-body p-0 bordered">
            @include("ui.customer.widgets.TablePaginatedCustomerList")
        </div>
    </div>
@endsection


