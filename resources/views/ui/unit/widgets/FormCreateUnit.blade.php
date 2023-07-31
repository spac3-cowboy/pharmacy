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
            <div class="card-header bg-pitla-blue">
                <h4 class="card-title">Add Unit</h4>
            </div>
            <div class="card-body">
                <form class="form" action="{{ route('units.store') }}" method="POST">
                    @csrf
                    <div class="col-12">
                        <div class="mb-1">
                            <label class="form-label" for="first-name-column">Unit Name</label>
                            <input type="text" id="last-name-column" class="form-control" placeholder="CategoryName" name="name" required="true" >
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
