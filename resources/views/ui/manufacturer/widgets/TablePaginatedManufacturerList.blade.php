<div class="table-responsive">
    <table class="table table-centered w-100 dt-responsive nowrap" id="manufacturers-datatable">
        <thead class="table-light">
            <tr>
                <th class="all">
                    #
                </th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Address</th>
                <th>Payable</th>
                <th>Medicine</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>


{{-- Setting Up Table Scripts--}}
<script>

	<!-- Datatable js -->
</script>


@section("scripts")

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

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
                    document.querySelector("#manufacturers-delete-"+mid).submit();
                } else if (result.isDenied) {

                }
            });
        }


        $(document).ready(function() {
            $('#manufacturers-datatable').DataTable({
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
                ajax: "{{ route('manufacturers.index') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'phone', name: 'phone' },
                    { data: 'email', name: 'email' },
                    { data: 'address', name: 'address' },
                    { data: 'payable', name: 'payable' },
                    { data: 'medicine', name: 'medicine' },
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
