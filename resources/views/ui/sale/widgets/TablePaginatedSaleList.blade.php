<div class="table-responsive">
    <table class="table table-centered w-100 dt-responsive nowrap" id="sales-datatable">
        <thead class="table-light">
            <tr>
                <th class="all">#</th>
                <th>Sale ID</th>
                <th>Customer</th>
                <th>Total Qty.</th>
                <th>Grand Total</th>
                <th>Paid</th>
                <th>Date</th>
                <th>Invoice</th>
                <th>Action</th>
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
        const deleteConfirm = (mid) => {
            Swal.fire({
                title: 'Are You Sure?',
                showDenyButton: true,
                confirmButtonText: 'Delete',
                denyButtonText: `No`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    document.querySelector("#stock-delete-"+mid).submit();
                } else if (result.isDenied) {

                }
            });
        }


        $(document).ready(function() {
            $('#sales-datatable').DataTable({
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
                ajax: "{{ route('sales.index') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'sale_id', name: 'sale_id' },
                    { data: 'customer', name: 'customer' },
                    { data: 'qty', name: 'qty' },
                    { data: 'total', name: 'total' },
                    { data: 'paid', name: 'paid' },
                    { data: 'date', name: 'date' },
                    { data: 'invoice', name: 'invoice' },
                    { data: 'action', name: 'action' },
                    // { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });
        });
    </script>

@endsection



@section("styles")
    <!-- Datatable css -->
    <link href="{{ asset('assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
