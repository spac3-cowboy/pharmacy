<div class="table-responsive">
    <table class="table table-centered w-100 dt-responsive nowrap" id="reports-datatable">
        <thead class="table-light">
            <tr>
                <th class="all">#</th>
                <th>Sale ID</th>
                <th>Customer</th>
                <th>Products</th>
                <th>Total Qty.</th>
                <th>Total Cost</th>
                <th>Date</th>
                <th>Invoice</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>


{{-- Setting Up Table Scripts--}}
<script>

</script>


@section("scripts")

    <script type="text/javascript">
        $('#filter').click(function () {
            $('#reports-datatable').DataTable().ajax.reload();
        });

        $(document).ready(function () {
            $('#reports-datatable').DataTable({
	            dom: 'Blfrtip',
	            buttons: [
		            {
			            extend: 'pdfHtml5',
			            text: 'PDF',
			            exportOptions: {
				            modifier: {
					            page: 'current'
				            }
			            }
		            },
		            {
			            extend: 'csvHtml5',
			            text: 'CSV',
			            exportOptions: {
				            modifier: {
					            page: 'current'
				            }
			            }
		            },
		            {
			            extend: 'copyHtml5',
			            text: 'Copy',
			            exportOptions: {
				            modifier: {
					            page: 'current'
				            }
			            }
		            },
		            {
			            extend: 'excelHtml5',
			            text: 'EXCEL',
			            exportOptions: {
				            modifier: {
					            page: 'current'
				            }
			            }
		            },

	            ],
                processing: true,
                serverSide: true,
                "ajax": {
                    "url": "{{ route('reports.sales') }}",
                    "type": 'GET',
                    "data": function (d) {
                        d.from = $("#from").val();
                        d.to = $("#to").val();
                        if ( $("#member_id").val() && $("#member_id").val().length ) {
                            d.member_id = $("#member_id").val();
                        }
                        if ( $("#collector_id").val() && $("#collector_id").val().length ) {
                            d.collector_id = $("#collector_id").val();
                        }
                    },
                    "dataType": "json",
                    "dataSrc": function (json) {
                        document.querySelector("#total-sales-value").innerText = json.total_sales_value;
                        // $("#total_commission").html('Total Commission : <small>£</small>' + parseFloat(json.total_amount).toFixed(2));
                        return json.data;
                    },
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'sale_id', name: 'sale_id'},
                    {data: 'customer', name: 'customer'},
                    {data: 'products', name: 'products'},
                    {data: 'total_quantity', name: 'total_quantity'},
                    {data: 'grand_total', name: 'grand_total'},
                    {data: 'date', name: 'date'},
                    {data: 'invoice', name: 'invoice'}
                ],
                columnDefs: [
                    { targets: 'filterable', searchable: true }
                ],
                order: [],
                error: function (xhr, error, thrown) {
                    // Handle the error case
                    console.log('Error:', error);
                    $('#example').html('An error occurred while loading the data.');
                }
            });
        });
    </script>

@endsection



@section("styles")
    <!-- Datatable css -->
    <link href="{{ asset('assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
