<div class="row">
    <div class="col-12">
        <div class="card shadow-none border">
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
            <div class="card-header bg-pitla-blue">
                <h4 class="card-title">Edit Tenant</h4>
            </div>
            <div class="card-body">
                <form class="form" action="{{ route('tenants.update', [ "tenant" => $tenant->id ]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row justify-content-around">
                        <div class="card border border-dark p-0 shadow-none col-5">
                            <div class="card-header bg-pitla-blue">Owner Details</div>
                            <div class="card-body bg-primary-lighten p-1">
                                <div class="form-group col-12 my-1">
                                    <label class="form-label" for="first-name-column">Owner Name<sup class="text-danger">*</sup></label>
                                    <input type="text" value="{{ $tenant->owner->name }}" id="name" class="form-control form-control-sm" placeholder="Name" name="name" required>
                                </div>
                                <div class="form-group col-12 my-1">
                                    <label class="form-label" for="first-name-column">Email <sup class="text-danger">*</sup></label>
                                    <input type="text" value="{{ $tenant->owner->email }}" id="email" class="form-control form-control-sm" placeholder="Email" name="email" required>
                                </div>
                                <div class="form-group col-12 my-1">
                                    <label class="form-label" for="first-name-column">Password <sup class="text-danger">*</sup></label>
                                    <input type="password" value="" id="password" class="form-control form-control-sm" placeholder="password" name="password">
                                </div>
                                <div class="form-group col-12 my-1">
                                    <label class="form-label" for="first-name-column">Phone <sup class="text-danger">*</sup></label>
                                    <input type="text" value="{{ $tenant->owner->phone }}" id="phone" class="form-control form-control-sm" placeholder="phone" name="phone" required>
                                </div>
                                <div class="form-group col-12 my-1">
                                    <label class="form-label" for="first-name-column">Address <sup class="text-danger">*</sup></label>
                                    <textarea name="address" id="address" cols="5" rows="5" class="form-control form-control-sm">{{ $tenant->owner->address }}</textarea>
                                </div>
                                <div class="form-group col-12 my-1">
                                    <label class="form-label" for="first-name-column">Blood Group<sup class="text-danger">*</sup></label>
                                    <select name="bg" id="bg" class="form-control form-control-sm">
                                        <option value="a+" {{ $tenant->bg == 'a+' ? 'selected' : '' }}>A+</option>
                                        <option value="b+" {{ $tenant->bg == 'b+' ? 'selected' : '' }}>B+</option>
                                        <option value="ab+" {{ $tenant->bg == 'ab+' ? 'selected' : '' }}>AB+</option>
                                        <option value="ab-" {{ $tenant->bg == 'ab-' ? 'selected' : '' }}>AB-</option>
                                        <option value="o+" {{ $tenant->bg == 'o+' ? 'selected' : '' }}>O+</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card border border-dark p-0 shadow-none col-5">
                            <div class="card-header bg-pitla-blue">Business Details</div>
                            <div class="card-body bg-info-lighten p-1">
                                <div class="form-group col-12 my-1">
                                    <img src="{{ $tenant->image }}" name="tenant_image" id="tenant_image_preview" alt="">
                                </div>
                                <div class="form-group col-12 my-1">
                                    <label class="form-label" for="first-name-column">Business Image<sup class="text-danger">*</sup></label>
                                    <input type="file" name="tenant_image" id="tenant_image" class="form-control form-control-sm" placeholder="Tenant Image" required>
                                </div>
                                <div class="form-group col-12 my-1">
                                    <label class="form-label" for="first-name-column">Business Name<sup class="text-danger">*</sup></label>
                                    <input value="{{ $tenant->name }}" type="text" id="tenant_name" class="form-control form-control-sm" placeholder="Tenant Name" name="tenant_name" required>
                                </div>
                                <div class="form-group col-12 my-1">
                                    <label class="form-label" for="first-name-column">Business Address <sup class="text-danger">*</sup></label>
                                    <textarea name="tenant_address" id="tenant_address" cols="5" rows="5" class="form-control form-control-sm">{{ $tenant->address }}</textarea>
                                </div>
                                <div class="form-group col-12 my-1">
                                    <label class="form-label" for="first-name-column">Business Email<sup class="text-danger">*</sup></label>
                                    <input value="{{ $tenant->email }}" type="text" id="tenant_email" class="form-control form-control-sm" placeholder="Tenant Email" name="tenant_email" required>
                                </div>
                                <div class="form-group col-12 my-1">
                                    <label class="form-label" for="first-name-column">Business Phone<sup class="text-danger">*</sup></label>
                                    <input value="{{ $tenant->phone }}" type="text" id="tenant_phone" class="form-control form-control-sm" placeholder="Tenant Phone" name="tenant_phone" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-12 mt-3 text-end">
                            <button type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
