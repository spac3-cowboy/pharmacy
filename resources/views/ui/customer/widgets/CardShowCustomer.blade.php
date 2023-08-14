<div class="card shadow-none">
    <div class="card-header bg-pitla-blue d-flex justify-content-between">
        <span>{{ $customer->name }}</span>
        <a href="{{ route('customers.edit', [ "customer" => $customer->id ]) }}" class="btn btn-info py-0">Edit</a>
    </div>
    <div class="card-body">
        <div class="row justify-content-around">
            <div class="col-lg-4 border-end p-2 rounded-1 bg-white">
                <img src="{{ $customer->image }}" alt="Photo of {{ $customer->name }}" class="img-thumbnail">
                <table class="table">
                    <tbody>
                    <tr>
                        <td>
                            <strong>Total Bought: </strong>
                            <span class="badge badge-primary-lighten">
                                    {{ $total_bought }}
                                </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Total Paid: </strong>
                            <span class="badge badge-success-lighten">
                                    {{ $total_paid }}
                                </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Total Due: </strong>
                            <span class="badge badge-danger-lighten">
                                    {{ $total_due }}
                                </span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-7 p-2 shadow-none bg-white d-flex align-items-center flex-column">
                <table class="table">
                    <tbody>
                    <tr>
                        <td><strong>Name: </strong> {{ $customer->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Age: </strong>{{ $customer->age }}</td>
                    </tr>
                    <tr>
                        <td><strong>Phone: </strong>{{ $customer->phone }}</td>
                    </tr>
                    <tr>
                        <td><strong>Email: </strong>{{ $customer->email }}</td>
                    </tr>
                    <tr>
                        <td><strong>Address: </strong>{{ $customer->address }}</td>
                    </tr>
                    <tr>
                        <td><strong>Blood Group: </strong>{{ $customer->bg }}</td>
                    </tr>
                    <tr>
                        <td><strong>Role: </strong>{{ $customer->role }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-2 border border-secondary pt-1">
            <div class="col-12">
                <table class="table table-centered w-100 dt-responsive nowrap" id="sales-datatable">
                    <thead class="table-light">
                    <tr>
                        <th class="all">#</th>
                        <th>Sale ID</th>
                        <th>Products</th>
                        <th>Total Qty</th>
                        <th>Grand Total</th>
                        <th>Paid</th>
                        <th>Due</th>
                        <th>Date</th>
                        <th>Invoice</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
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
	$(document).ready(function() {
		$('#sales-datatable').DataTable({
			processing: true,
			serverSide: true,
			ajax: "{{ route('customers.show', [ 'customer' => $customer->id ]) }}",
			columns: [
				{ data: 'id', name: 'id' },
				{ data: 'sale_id', name: 'sale_id' },
				{ data: 'products', name: 'products' },
				{ data: 'qty', name: 'qty' },
				{ data: 'grand_total', name: 'grand_total' },
				{ data: 'paid', name: 'paid' },
				{ data: 'due', name: 'due' },
				{ data: 'date', name: 'date' },
				{ data: 'invoice', name: 'invoice' }
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