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
            <div class="card-header bg-pitla-blue py-0">
                ADD MEDICINE
            </div>
            <div class="card-body">
                <form class="form" action="{{ route('admin.medicines.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-6 my-1">
                            <label class="form-label" for="first-name-column">Name <sup class="text-danger">*</sup></label>
                            <input type="text" id="name" class="form-control" placeholder="Name" name="name" required>
                        </div>

                        <div class="form-group col-6 my-1">
                            <label class="form-label" for="first-name-column">Generic Name <sup class="text-danger">*</sup></label>
                            <input type="text" id="generic_name" class="form-control" placeholder="Generic Name" name="generic_name" required>
                        </div>


                        <div class="form-group col-6 my-1">
                            <label class="form-label" for="first-name-column">Selling Price / MRP<sup class="text-danger">*</sup></label>
                            <input type="number" min="0.01" step="0.01" id="price" class="form-control" placeholder="price" name="price" required>
                        </div>

                        <div class="form-group col-6 my-1">
                            <label class="form-label" for="first-name-column">Manufacturing Price <sup class="text-danger">*</sup></label>
                            <input type="number" min="0.01" step="0.01" id="manufacturing_price" class="form-control" placeholder="Manufacturing Price" name="manufacturing_price" required>
                        </div>

                        <div class="form-group col-6 my-1">
                            <label class="form-label" for="first-name-column">Shelf <small class="text-secondary">(optional)</small></label>
                            <input type="text" id="shelf" class="form-control" placeholder="Shelf" name="shelf">
                        </div>

                        <div class="form-group col-6 my-1">
                            <label class="form-label" for="first-name-column">Strength <sup class="text-danger">*</sup></label>
                            <input type="text" id="strength" class="form-control" placeholder="Strength" name="strength" required>
                        </div>

                        <div class="form-group col-6 my-1">
                            <label class="form-label" for="first-name-column">Category <sup class="text-danger">*</sup></label>
                            <select class="form-select" id="category" name="category_id" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-6 my-1">
                            <label class="form-label" for="first-name-column">
                                Unit <sup class="text-danger">*</sup>
                            </label>
                            <select style="padding: 10px" class="form-select" id="unit" name="unit_id"  required>
                                @foreach($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-12 mt-3 text-end">
                        <button type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary waves-effect">Reset</button>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@section("styles")
    <link rel="stylesheet" href="{{ asset("assets/vendor/select2/css/select2.min.css") }}">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

@endsection


@section("scripts")
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <!-- Select2 js -->
    <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>

    <script type="text/javascript">
        const medicines = {!! "[" . $medicines->reduce(function ($total, $m){ return '"' . $m->name . '" ,' . $total; }, "]") !!};
	    $(document).ready(function() {
		    $( "#name" ).autocomplete({
			    source: medicines
		    });
		    $( "#unit" ).select2({
                padding: "10px"
            });
		    $( "#category" ).select2();
		    $( "#manufacturer" ).select2();
		    $( "#unit" ).select2();
	    });
    </script>


    <script>
        async function createMedicine(e) {
            e.preventDefault();
			await fetch().then(res=>res.json())
        }
    </script>

@endsection

