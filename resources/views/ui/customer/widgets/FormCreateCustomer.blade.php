<div class="row">
    <div class="col-12">
        <div class="card">
            {{-- End Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            {{-- End Errors --}}
            <div class="card-header">
                <h4 class="card-title">Add Customer</h4>
            </div>
            <div class="card-body">
                <form class="form" action="{{ route('customers.store') }}" method="POST">
                    @csrf
                    <div class="col-md-6 col-12">
                        <div class="mb-1">
                            <label class="form-label" for="first-name-column">Name</label>
                            <input type="text" id="last-name-column" class="form-control" placeholder="Name" name="name" required="">
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="mb-1">
                            <label class="form-label" for="first-name-column">Email</label>
                            <input type="email" id="last-name-column" class="form-control" placeholder="Email" name="email" required="">
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="mb-1">
                            <label class="form-label" for="city-column">Phone</label>
                            <input type="text" id="city-column" class="form-control" placeholder="Phone" name="phone" required="">
                            <small>Enter phone with country code (+000) </small>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="mb-1">
                            <label class="form-label" for="last-name-column">Address</label>
                            <input type="text" id="last-name-column" class="form-control" placeholder="Address" name="address" required="">
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="mb-1">
                            <label class="form-label" for="country-floating">Due</label>
                            <input type="number" step="0.01" id="country-floating" class="form-control" name="due" placeholder="Due">
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary waves-effect">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
