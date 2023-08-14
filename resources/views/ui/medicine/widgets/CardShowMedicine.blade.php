<div class="card shadow-none pb-0">
    <div class="card-header bg-pitla-blue d-flex justify-content-between">
        <span>{{ $medicine->name }}</span>
        <a href="{{ route('medicines.edit', [ "medicine" => $medicine->id ]) }}" class="btn btn-info py-0">Edit</a>
    </div>
    <div class="card-body pb-0">
        <div class="row justify-content-around">
            <div class="col-4 p-0 m-0 text-center d-flex justify-content-center align-items-center">
                <img class="img-thumbnail" height="280px" width="280px" src="/category/{{ $medicine->image }}" alt="">
            </div>
            <div class="col-6  d-flex justify-content-center align-items-center">
                <table class="table border">
                    <tbody>
                        <tr>
                            <td class="py-1">
                                <strong>Name:</strong>
                                {{ $medicine->name }}
                            </td>
                        </tr>
                        <tr>
                            <td class="py-1">
                                <strong>Generic Name:</strong>
                                {{ $medicine->generic_name }}</td>
                        </tr>
                        <tr>
                            <td class="py-1">
                                <strong>Shelf:</strong>
                                {{ $medicine->shelf }}</td>
                        </tr>
                        <tr>
                            <td class="py-1">
                                <strong>Selling Price:</strong>
                                {{ $medicine->price }}</td>
                        </tr>
                        <tr>
                            <td class="py-1">
                                <strong>Manufacturing Price:</strong>
                                {{ $medicine->manufacturing_price }}
                            </td>
                        </tr>
                        <tr>
                            <td class="py-1">
                                <strong>Category:</strong>
                                {{ $medicine->category->name }}
                            </td>
                        </tr>
                        <tr>
                            <td class="py-1">
                                <strong>Manufacturer:</strong>
                                {{ $medicine->manufacturer->name }}
                            </td>
                        </tr>
                        <tr>
                            <td class="py-1">
                                <strong>Unit:</strong>
                                {{ $medicine->unit->name }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-2 p-0">
            <div class="col-12">

            </div>
        </div>
    </div>
</div>


@section("scripts")
<!-- Datatable js -->
<script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables-checkboxes/js/dataTables.checkboxes.min.js') }}"></script>


<script>
	
</script>
@endsection

@section("styles")
    <!-- Datatable css -->
    <link href="{{ asset('assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
@endsection