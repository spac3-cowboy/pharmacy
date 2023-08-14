@extends("Layout.MainLayout")



@section("title", "Dashboard")

@section("main")
    <div class="row">
		<div class="col-4">
			<div class="card border shadow-none">
				<div class="card-header py-0 bg-pitla-blue">
					Top Medicines
				</div>
				<div class="card-body d-flex justify-content-start p-0">
					<table class="table table-striped w-100 p-0 m-0">
						<thead class="bg-info-lighten">
						<tr class="py-1">
							<th class="py-1">Name</th>
							<th class="py-1">Sold</th>
							<th class="py-1">Amount</th>
						</tr>
						</thead>
						<tbody>
						@foreach($top_sold_medicines as $tsm)
							<tr class="py-0">
								<td class="py-0">
									{{ $tsm->name }}
								</td>
								<td class="py-0">{{ $tsm->sold }}</td>
								<td class="py-0">{{ $tsm->amount }}</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
{{--		<div class="col-4">--}}
{{--			<div class="card border shadow-none">--}}
{{--				<div class="card-header py-1 bg-pitla-blue">--}}
{{--					Top Medicines--}}
{{--				</div>--}}
{{--				<div class="card-body d-flex justify-content-start p-0">--}}
{{--					<table class="table table-striped w-100 p-0 m-0">--}}
{{--						<thead class="bg-secondary-lighten">--}}
{{--						<tr class="py-1">--}}
{{--							<th class="py-1">Name</th>--}}
{{--							<th class="py-1">Sold</th>--}}
{{--							<th class="py-1">Amount</th>--}}
{{--						</tr>--}}
{{--						</thead>--}}
{{--						<tbody>--}}
{{--						@foreach($top_sold_medicines as $tsm)--}}
{{--							<tr class="py-0">--}}
{{--								<td class="py-0">--}}
{{--									{{ $tsm->name }}--}}
{{--								</td>--}}
{{--								<td class="py-0">{{ $tsm->sold }}</td>--}}
{{--								<td class="py-0">{{ $tsm->amount }}</td>--}}
{{--							</tr>--}}
{{--						@endforeach--}}
{{--						</tbody>--}}
{{--					</table>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--		</div>--}}
{{--		<div class="col-4">--}}
{{--			<div class="card border shadow-none">--}}
{{--				<div class="card-header py-1 bg-pitla-blue">--}}
{{--					Top Medicines--}}
{{--				</div>--}}
{{--				<div class="card-body d-flex justify-content-start p-0">--}}
{{--					<table class="table table-striped w-100 p-0 m-0">--}}
{{--						<thead class="bg-secondary-lighten">--}}
{{--						<tr class="py-1">--}}
{{--							<th class="py-1">Name</th>--}}
{{--							<th class="py-1">Sold</th>--}}
{{--							<th class="py-1">Amount</th>--}}
{{--						</tr>--}}
{{--						</thead>--}}
{{--						<tbody>--}}
{{--						@foreach($top_sold_medicines as $tsm)--}}
{{--							<tr class="py-0">--}}
{{--								<td class="py-0">--}}
{{--									{{ $tsm->name }}--}}
{{--								</td>--}}
{{--								<td class="py-0">{{ $tsm->sold }}</td>--}}
{{--								<td class="py-0">{{ $tsm->amount }}</td>--}}
{{--							</tr>--}}
{{--						@endforeach--}}
{{--						</tbody>--}}
{{--					</table>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--		</div>--}}
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


@section("styles")
	<style>
		.table table tr td {
			padding-top: 0px!important;
			padding-bottom: 0px!important;
		}
	</style>
@endsection