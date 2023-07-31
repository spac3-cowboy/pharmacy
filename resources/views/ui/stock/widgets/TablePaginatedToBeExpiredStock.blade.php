<div class="table-responsive">
    <table class="table table-centered w-100 dt-responsive nowrap" id="stocks-datatable">
        <thead class="table-light">
            <tr>
                <th class="all">#</th>
                <th>Batch</th>
                <th title="Available Quantity">Avl. Qty</th>
                <th>Name</th>
                <th>Generic Name</th>
                <th>Shelf</th>
                <th>Buy Price</th>
                <th>Selling Price</th>
                <th>Strength</th>
                <th>Category</th>
                <th>Purchase Date</th>
                <th>Manufacturing Date</th>
                <th>Expiry Date</th>
                <th>Cost</th>
                <th>Manufacturer</th>
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
            $('#stocks-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('stocks.outofstock') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'batch', name: 'batch' },
                    { data: 'avl_qty', name: 'avl_qty' },
                    { data: 'name', name: 'name' },
                    { data: 'generic_name', name: 'generic_name' },
                    { data: 'shelf', name: 'shelf' },
                    { data: 'buy_price', name: 'buy_price' },
                    { data: 'price', name: 'price' },
                    { data: 'strength', name: 'strength' },
                    { data: 'purchase_date', name: 'purchase_date' },
                    { data: 'manufacturer', name: 'manufacturer' },
                    { data: 'manufacturing_date', name: 'manufacturing_date' },
                    { data: 'expiry_date', name: 'expiry_date' },
                    { data: 'cost', name: 'cost' },
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
