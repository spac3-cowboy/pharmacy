<div class="row">
    <div class="col-12">
        <div class="card shadow-none border w-50">
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
            <div class="card-header bg-pitla-blue py-0">
                Edit Vendor
            </div>
            <div class="card-body">
                <form class="form" action="{{ route('vendors.update', ["vendor" => $vendor->id ]) }}" method="POST">
                    @csrf
                    @method("PUT")
                    <div class="col-12">
                        <div class="mb-1">
                            <label class="form-label" for="first-name-column">Name</label>
                            <input value="{{ $vendor->name }}" type="text" id="last-name-column" class="form-control" placeholder="Name" name="name" required="">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-1">
                            <label class="form-label" for="first-name-column">Email</label>
                            <input value="{{ $vendor->email }}" type="email" id="last-name-column" class="form-control" placeholder="Email" name="email" required="">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-1">
                            <label class="form-label" for="city-column">Phone</label>
                            <input value="{{ $vendor->phone }}" type="text" id="city-column" class="form-control" placeholder="Phone" name="phone" required="">
                            <small>Enter phone with country code (+000) </small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-1">
                            <label class="form-label" for="last-name-column">Address</label>
                            <input value="{{ $vendor->address }}" type="text" id="last-name-column" class="form-control" placeholder="Address" name="address" required="">
                        </div>
                    </div>
                    <div class="col-12 mt-3 text-end">
                        <button type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary waves-effect">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
