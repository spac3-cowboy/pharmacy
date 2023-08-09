<div class="table-responsive">
    <table class="table table-centered w-100 dt-responsive nowrap" id="medicines-datatable">
        <thead class="table-light">
            <tr>
                <th class="all">#</th>
                <th>Batch</th>
                <th title="Available Quantity">Avl. Qty</th>
                <th>Name</th>
                <th>Generic Name</th>
                <th>Shelf</th>
                <th>Manufacturing Price</th>
                <th>Selling Price</th>
                <th>Strength</th>
                <th>Category</th>
                <th>Manufacturer</th>
                <th>Purchase Date</th>
                <th>Manufacturing Date</th>
                <th>Expiry Date</th>
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
            $('#stocks-datatable').DataTable({
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
                ajax: "{{ route('stocks.index') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'batch', name: 'batch' },
                    { data: 'avl_qty', name: 'avl_qty' },
                    { data: 'name', name: 'name' },
                    { data: 'generic_name', name: 'generic_name' },
                    { data: 'shelf', name: 'shelf' },
                    { data: 'manufacturing_price', name: 'manufacturing_price' },
                    { data: 'price', name: 'price' },
                    { data: 'strength', name: 'strength' },
                    { data: 'category', name: 'category' },
                    { data: 'manufacturer', name: 'manufacturer' },
                    { data: 'purchase_date', name: 'purchase_date' },
                    { data: 'manufacturing_date', name: 'manufacturing_date' },
                    { data: 'expiry_date', name: 'expiry_date' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
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
