<div class="table-responsive">
    <table class="table table-centered w-100 dt-responsive nowrap" id="reports-datatable">
        <thead class="table-light">
            <tr>
                <th class="all">#</th>
                <th>Image</th>
                <th>Name</th>
                <th>Generic Name</th>
                <th>price</th>
                <th>Category</th>
                <th>Manufacturer</th>
                <th>Sales</th>
                <th>Sold Amount</th>
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
    <script src="https://cdnjs.com/libraries/Chart.js"></script>

    <!-- Datatable js -->
    <script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-datatables-checkboxes/js/dataTables.checkboxes.min.js') }}"></script>

    <!-- Product Demo App js -->
    {{--    <script src="{{ asset('assets/js/pages/demo.products.js') }}"></script>--}}

    <script type="text/javascript">
        $('#filter').click(function () {
            $('#reports-datatable').DataTable().ajax.reload();
        });

        $(document).ready(function () {
            $('#reports-datatable').DataTable({
                processing: true,
                serverSide: true,
                "dom": 'Blfrtip',
                {{--ajax: "{{ route('report.generate') }}",--}}
                {{--"data": function (d) {--}}
                {{-- 	d.from = $("#from").val();--}}
                {{-- 	d.to = $("#to").val();--}}
                {{-- 	d.member_id = $("#member_id").val();--}}
                {{-- 	d.collector_id = $("#collector_id").val();--}}
                {{--},--}}
                // data: [
                // 	{
                // 		"name": "from",
                // 		"value" : $("#from").val()
                // 	}
                // ],
                "ajax": {
                    "url": "{{ route('reports.topsoldmedicines') }}",
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
                        document.querySelector("#total-sales-value").innerHTML = `<span class="badge badge-secondary-lighten border border-light">${json.total_sale_amount}</span>`;
                        // $("#total_commission").html('Total Commission : <small>£</small>' + parseFloat(json.total_amount).toFixed(2));
                        return json.data;
                    },
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'image', name: 'image'},
                    {data: 'name', name: 'name'},
                    {data: 'generic_name', name: 'generic_name'},
                    {data: 'price', name: 'price'},
                    {data: 'category', name: 'category'},
                    {data: 'manufacturer', name: 'manufacturer'},
                    {data: 'sale', name: 'sales'},
                    {data: 'sold_amount', name: 'sold_amount'}
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
