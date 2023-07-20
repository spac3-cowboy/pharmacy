<div class="table-responsive">
    <table class="table table-centered w-100 dt-responsive nowrap" id="medicines-datatable">
        <thead class="table-light">
            <tr>
                <th class="all">
                    #
                </th>
                <th>Name</th>
                <th>Generic Name</th>
                <th>Shelf</th>
                <th>price</th>
                <th>Manufacturing Price</th>
                <th>Strength</th>
                <th>Image</th>
                <th>Category</th>
                <th>Manufacturer</th>
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
                    document.querySelector("#medicine-delete-"+mid).submit();
                } else if (result.isDenied) {

                }
            });
        }


        $(document).ready(function() {
            $('#medicines-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('medicines.index') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'generic_name', name: 'generic_name' },
                    { data: 'shelf', name: 'shelf' },
                    { data: 'price', name: 'price' },
                    { data: 'manufacturing_price', name: 'manufacturing_price' },
                    { data: 'strength', name: 'strength' },
                    { data: 'image', name: 'image' },
                    { data: 'category', name: 'category' },
                    { data: 'manufacturer', name: 'manufacturer' },
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