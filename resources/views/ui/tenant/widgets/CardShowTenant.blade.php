<div class="row">
    <div class="col-6">
        <div class="card p-1 shadow-none border">
            <div class="card-body  p-1">
                <strong>
                    Name: <span class="badge badge-secondary-lighten">{{ $tenant->name }}</span>
                </strong>
                <br />
                <strong>
                    Address: <span class="badge badge-secondary-lighten">{{ $tenant->address }}</span>
                </strong>
                <br />
                <strong>
                    Email: <span class="badge badge-secondary-lighten">{{ $tenant->email }}</span>
                </strong>
                <br />
                <strong>
                    Phone: <span class="badge badge-secondary-lighten">{{ $tenant->phone }}</span>
                </strong>
                <br />
                <strong>
                    Created At: <span class="badge badge-secondary-lighten">{{ $tenant->created_at }}</span>
                </strong>
                <br />
                <strong>
                    Admin: <span class="badge badge-secondary-lighten">{{ $tenant->owner->name }}</span>
                </strong>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card shadow-none border">
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item py-0">
                        Categories: <span class="badge badge-secondary-lighten">{{ $categories->count() }}</span>
{{--                        <div class="btn text-primary">view</div>--}}
                    </li>
                    <li class="list-group-item py-0">
                        Medicines: <span class="badge badge-secondary-lighten">{{ $medicines->count() }}</span>
                    </li>
                    <li class="list-group-item py-0">
                        Manufacturers: <span class="badge badge-secondary-lighten">{{ $manufacturers->count() }}</span>
                    </li>
                    <li class="list-group-item py-0">
                        Vendors: <span class="badge badge-secondary-lighten">{{ $vendors->count() }}</span>
                    </li>
                    <li class="list-group-item py-0">
                        Stocks: <span class="badge badge-secondary-lighten">{{ $stocks->count() }}</span>
                    </li>
                    <li class="list-group-item py-0">
                        Purchases: <span class="badge badge-secondary-lighten">{{ $purchases->count() }}</span>
                    </li>
                    <li class="list-group-item py-0">
                        Sales: <span class="badge badge-secondary-lighten">{{ $sales->count() }}</span>
                    </li>
                    <li class="list-group-item py-0">
                        Customers: <span class="badge badge-secondary-lighten">{{ $customers->count() }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
