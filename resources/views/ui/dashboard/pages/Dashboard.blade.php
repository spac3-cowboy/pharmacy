@extends("Layout.MainLayout")



@section("title", "Dashboard")

@section("main")
    <div class="row">
        <div class="col-12">
            <div class="card border shadow-none">
                <div class="card-header bg-pitla-blue">Reports</div>
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
                            <h4>Total Prchase</h4>
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
    </div>
    <div class="row">
        <div class="col-6">
            <div class="card rounded">
                <div class="card-header py-0 bg-info text-white">
                    Sales Chart
                </div>
                <div class="card-body p-1">
                    <canvas id="sale-canvas"></canvas>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card rounded">
                <div class="card-header py-0 bg-info text-white">
                    Purchase Chart
                </div>
                <div class="card-body p-1">
                    <canvas id="purchase-canvas"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
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
                        <div class="card-header bg-danger text-white">Out Of Stock Medicines</div>
                        <div class="card-body p-0">
                            <table class="table p-0 mb-0">
                                <thead>
                                <tr>
                                    <th class="py-1">Name</th>
                                </tr>
                                @foreach($out_of_stocks as $stock)
                                    <tr>
                                        <td class="py-1">
                                            <a href="{{ route('medicines.show', ["medicine" => $stock->medicine->id]) }}">{{ $stock->medicine->name }}</a>
                                        </td>
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
                                        <td class="py-1">
                                            <a href="{{ route('medicines.show', ["medicine" => $stock->medicine->id]) }}">{{ $stock->medicine->name }}</a>
                                        </td>
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
        <!-- Pie Chart -->
        <div class="col-5">
            <div class="card">
                <div class="card-header bg-pitla-blue">Sale Purchase Ratio</div>
                <div class="card-body">
                    <canvas id="pie-chart"></canvas>
                </div>
            </div>
        </div>
        <!-- End Pie Chart -->
    </div>
@endsection


@section("scripts")
    <script src="{{ asset('assets/vendor/chart.js/chart.min.js') }}"></script>
    <script>
	    const data = [
		    { year: 2010, count: 10 },
		    { year: 2011, count: 20 },
		    { year: 2012, count: 15 },
		    { year: 2013, count: 25 },
		    { year: 2014, count: 22 },
		    { year: 2015, count: 30 },
		    { year: 2016, count: 28 },
	    ];
	    new Chart( document.getElementById('sale-canvas'), {
			    type: 'line',
			    options: {
				    animation: false,
				    plugins: {
					    legend: {
						    display: false
					    },
					    tooltip: {
						    enabled: true
					    }
				    }
			    },
			    data: {
				    labels: ["Jan", "Feb", "Mar", "Apr", "Mar", "May", "Jun"],
				    datasets: [
						{
                            label: 'Sale',
                            data: [65, 59, 80, 81, 56, 55, 40],
                            fill: false,
                            borderColor: 'green',
                            tension: 0,
				        }
					]
			    }
		    }
	    );
	    new Chart( document.getElementById('purchase-canvas'), {
			    type: 'line',
			    options: {
				    animation: false,
				    plugins: {
					    legend: {
						    display: false
					    },
					    tooltip: {
						    enabled: true
					    }
				    }
			    },
			    data: {
				    labels: ["Jan", "Feb", "Mar", "Apr", "Mar", "May", "Jun"],
				    datasets: [
					    {
						    label: 'Sale',
						    data: [80, 59, 65, 41, 5, 55, 80],
						    fill: false,
						    borderColor: 'red',
						    tension: 0,
					    }
				    ]
			    }
		    }
	    );

        const chartData = {
	        labels: ['Sale', 'Purchase'],
	        datasets: [
		        {
			        label: 'Dataset 1',
			        data: [20, 80],
			        backgroundColor: ['dodgerblue', 'lightcoral'],
		        },
	        ],
	        borderWidth: 1,
        };
	    new Chart( document.getElementById('pie-chart'),
		    {
			    type: 'pie',
			    data: chartData,
			    options: {
				    plugins: {
					    legend: true,
					    tooltip: true,
				    },
				    elements: {
					    arc: {
						    backgroundColor: 'red',
						    hoverBackgroundColor: 'coral'
					    }
				    },
				    cutout: '50%',
			    }
		    }
	    );

		

    </script>
@endsection
