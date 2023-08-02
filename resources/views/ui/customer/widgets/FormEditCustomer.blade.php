<div class="row">
    <div class="col-6">
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
                <h4 class="card-title">Edit Customer</h4>
            </div>
            <div class="card-body">
                <form class="form" action="{{ route('customers.update', [ "customer" => $customer->id ]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class=" col-12">
                        <div class="mb-1">
                            <label class="form-label" for="first-name-column">Name</label>
                            <input value="{{ $customer->name }}" type="text" id="last-name-column" class="form-control" placeholder="Name" name="name" required>
                        </div>
                    </div>
                    <div class=" col-12">
                        <div class="mb-1">
                            <label class="form-label" for="first-name-column">Age</label>
                            <input value="{{ $customer->age }}" type="number" id="last-name-column" class="form-control" placeholder="Age" name="age" required>
                        </div>
                    </div>
                    <div class=" col-12">
                        <div class="mb-1">
                            <label class="form-label" for="first-name-column">Age</label>
                            <input value="{{ $customer->bg }}" type="text" id="last-name-column" class="form-control" placeholder="Blood Group" name="bg" required>
                        </div>
                    </div>
                    <div class=" col-12">
                        <div class="mb-1">
                            <label class="form-label" for="first-name-column">Email</label>
                            <input value="{{ $customer->email }}" type="email" id="last-name-column" class="form-control" placeholder="Email" name="email" required="">
                        </div>
                    </div>
                    <div class=" col-12">
                        <div class="mb-1">
                            <label class="form-label" for="city-column">Phone</label>
                            <input value="{{ $customer->phone }}" type="text" id="city-column" class="form-control" placeholder="Phone" name="phone" required="">
                            <small>Enter phone with country code (+000) </small>
                        </div>
                    </div>
                    <div class=" col-12">
                        <div class="mb-1">
                            <label class="form-label" for="last-name-column">Address</label>
                            <textarea value="{{ $customer->address }}" type="text" id="last-name-column" class="form-control" placeholder="Address" name="address" required="" > </textarea>
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
