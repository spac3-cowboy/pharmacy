<div class="card shadow-none">
    <div class="card-header bg-pitla-blue d-flex justify-content-between">
        <span>{{ $customer->name }}</span>
        <a href="{{ route('customers.edit', [ "customer" => $customer->id ]) }}" class="btn btn-info py-0">Edit</a>
    </div>
    <div class="card-body">
        <div class="row justify-content-around">
            <div class="col-lg-4 border border-danger p-2 rounded-1 shadow bg-white">
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
            <div class="col-lg-7 border p-2 shadow-none bg-white d-flex align-items-center flex-column">

            </div>
        </div>
    </div>
</div>