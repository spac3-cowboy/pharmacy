@extends("Layout.MainLayout")


@section("title", "Dashboard")

@section("main")
	<div class="row m-2 p-2 px-0 border bg-white justify-content-center">
		<div class="col-lg-3 col-sm-12 mb-1">
			<div style="" class="card mx-1 p-0 mb-0 shadow-none border border-danger w-100">
				<div class="card-body p-1">
					<h4>
						<i class="uil uil-coins"></i> Stock
					</h4>
					<strong class="badge badge-secondary-lighten">In Stock: {{ $stock_medicines }}</strong>
					<strong class="badge badge-secondary-lighten">Stock Out: {{ $out_of_stocks->count() }}</strong>
					<strong class="badge badge-secondary-lighten">Expired: {{ $expired_stocks->count() }}</strong>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-sm-12 mb-1">
			<div style="" class="card mx-1 p-0 mb-0  shadow-none border border-danger w-100">
				<div class="card-body p-1">
					<h4>
						<i class="uil uil-money-withdrawal"></i> Sales
					</h4>
					<strong class="badge badge-secondary-lighten">Today: {{ $total_sales_today }}</strong>
					<strong class="badge badge-secondary-lighten">This Week: {{ $total_sales_week }}</strong>
					<strong class="badge badge-secondary-lighten">This Month: {{ $total_sales_month }}</strong>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-sm-12 mb-1">
			<div style="" class="card mx-1 p-0 mb-0  shadow-none border border-danger w-100">
				<div class="card-body p-1">
					<h4>
						<i class="uil uil-money-insert"></i> Purchase
					</h4>
					<strong class="badge badge-secondary-lighten">Today: {{ $total_purchase_today }}</strong>
					<strong class="badge badge-secondary-lighten">This Week: {{ $total_purchase_week }}</strong>
					<strong class="badge badge-secondary-lighten">This Month: {{ $total_purchase_month }}</strong>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-sm-12 mb-1">
			<div style="" class="card mx-1 p-0 mb-0  shadow-none border border-danger w-100">
				<div class="card-body p-1">
					<h4>
						<i class="mdi mdi-keyboard-tab-reverse"></i> Returns
					</h4>
					<strong class="badge badge-secondary-lighten">Today: {{ $total_return_today }}</strong>
					<strong class="badge badge-secondary-lighten">This Week: {{ $total_return_week }}</strong>
					<strong class="badge badge-secondary-lighten">This Month: {{ $total_return_month }}</strong>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6 col-sm-12">
			<div class="card rounded">
				<div class="card-header py-0 bg-info text-white">
					Sales Chart
				</div>
				<div class="card-body p-1">
					<canvas id="sale-canvas"></canvas>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-sm-12">
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
		<div class="col-lg-7 col-sm-12">
			<div class="row">
				<div class="col-lg-6 col-sm-12">
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
				<div class="col-lg-6 col-sm-12">
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
				<div class="col-lg-6 col-sm-12">
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
				<div class="col-lg-6 col-sm-12">
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
		<div class="col-lg-5 col-sm-12">
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
			{year: 2010, count: 10},
			{year: 2011, count: 20},
			{year: 2012, count: 15},
			{year: 2013, count: 25},
			{year: 2014, count: 22},
			{year: 2015, count: 30},
			{year: 2016, count: 28},
		];
		new Chart(document.getElementById('sale-canvas'), {
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
		new Chart(document.getElementById('purchase-canvas'), {
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
		new Chart(document.getElementById('pie-chart'),
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
