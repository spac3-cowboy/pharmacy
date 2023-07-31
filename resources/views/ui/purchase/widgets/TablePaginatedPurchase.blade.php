<div class="table-responsive">
    <table class="table table-centered w-100 dt-responsive nowrap" id="purchase-datatable">
        <thead class="table-light">
            <tr>
                <th class="all">#</th>
                <th>Purchase Date</th>
                <th>Amount</th>
                <th>Paid Amount</th>
                <th>Medicines</th>
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
    <!-- Datatable js -->
    <script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-datatables-checkboxes/js/dataTables.checkboxes.min.js') }}"></script>

    <!-- Product Demo App js -->
    {{--    <script src="{{ asset('assets/js/pages/demo.products.js') }}"></script>--}}

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
            $('#purchase-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('purchases.index') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'purchase_date', name: 'purchase_date' },
                    { data: 'amount', name: 'amount' },
                    { data: 'paid', name: 'paid' },
                    { data: 'medicines', name: 'medicines' },
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
