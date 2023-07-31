@extends("Layout.MainLayout")



@section("title", "Dashboard")

@section("main")
    <div class="row">
        <div class="col-7">
            <div class="card border border-dark shadow-none">
                <div class="card-header">Reports</div>
                <div class="card-body px-1 d-flex justify-content-around ">
                    <div class="card mx-1 p-0 shadow-none border border-danger w-25">
                        <div class="card-body p-1">
                            <h4>Total Stock</h4>
                            <strong class="badge badge-secondary-lighten">{{ $stock_medicines }}</strong>
                        </div>
                    </div>
                    <div class="card mx-1 p-0 shadow-none border border-danger w-25">
                        <div class="card-body p-1">
                            <h4>Total Sales</h4>
                            <strong class="badge badge-secondary-lighten">{{ $total_sales }}</strong>
                        </div>
                    </div>
                    <div class="card mx-1 p-0 shadow-none border border-danger w-25">
                        <div class="card-body p-1">
                            <h4>Expired Stock</h4>
                            <strong class="badge badge-secondary-lighten">{{ $expired_stocks->count() }}</strong>
                        </div>
                    </div>
                    <div class="card mx-1 p-0 shadow-none border border-danger w-25">
                        <div class="card-body p-1">
                            <h4>Out of Stock</h4>
                            <strong class="badge badge-secondary-lighten">{{ $out_of_stocks->count() }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-7">
            <div class="row">
                <div class="col-6">
                    <div class="card p-0">
                        <div class="card-header bg-pitla-blue">Today's Seles</div>
                        <div class="card-body p-0">
                            <table class="table p-0 mb-0">
                                <thead>
                                    <tr>
                                        <th class="py-1">Total Sales</th>
                                        <th class="py-1">{{ $total_sales }}</th>
                                    </tr>
                                    <tr>
                                        <th class="py-1">Sold Amount</th>
                                        <th class="py-1">{{ $total_sales_amount }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card p-0">
                        <div class="card-header bg-danger text-white">Today's Purchases</div>
                        <div class="card-body p-0">
                            <table class="table p-0 mb-0">
                                <thead>
                                <tr>
                                    <th class="py-1">Total Purchases</th>
                                    <th class="py-1">{{ $total_purchases }}</th>
                                </tr>
                                <tr>
                                    <th class="py-1">Purchase Amount</th>
                                    <th class="py-1">{{ $total_purchase_amount }}</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card p-0">
                        <div class="card-header bg-pitla-blue">Out Of Stock Medicines</div>
                        <div class="card-body p-0">
                            <table class="table p-0 mb-0">
                                <thead>
                                <tr>
                                    <th class="py-1">Name</th>
                                </tr>
                                @foreach($out_of_stocks as $stock)
                                <tr>
                                    <td class="py-1">{{ $stock->medicine->name }}</td>
                                </tr>
                                @endforeach
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card p-0">
                        <div class="card-header bg-pitla-blue">Expired Medicines</div>
                        <div class="card-body p-0">
                            <table class="table p-0 mb-0">
                                <thead>
                                <tr>
                                    <th class="py-1">Name</th>
                                    <th class="py-1">Batch</th>
                                </tr>
                                @foreach($expired_stocks as $stock)
                                <tr>
                                    <td class="py-1">{{ $stock->medicine->name }}</td>
                                    <td class="py-1">{{ $stock->batch }}</td>
                                </tr>
                                @endforeach
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
