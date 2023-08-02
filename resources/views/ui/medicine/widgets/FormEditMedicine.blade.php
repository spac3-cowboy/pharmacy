<div class="row">
    <div class="col-12">
        <div class="card shadow-none border border-danger">
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
                <h4 class="card-title">Edit Medicine</h4>
            </div>
            <div class="card-body">
                <form class="form" action="{{ route('medicines.update', ["medicine" => $medicine->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <div class="row">
                        <div class="form-group col-6 my-1">
                            <label class="form-label" for="first-name-column">Name <sup class="text-danger">*</sup></label>
                            <input type="text" id="name" class="form-control" value="{{ $medicine->name }}" placeholder="Name" name="name" required>
                        </div>

                        <div class="form-group col-6 my-1">
                            <label class="form-label" for="first-name-column">Generic Name <sup class="text-danger">*</sup></label>
                            <input type="text" id="generic_name" class="form-control" value="{{ $medicine->generic_name }}" placeholder="Generic Name" name="generic_name" required>
                        </div>


                        <div class="form-group col-6 my-1">
                            <label class="form-label" for="first-name-column">Selling Price <sup class="text-danger">*</sup></label>
                            <input type="number" min="0.01" step="0.01" id="price" value="{{ $medicine->price }}" class="form-control" placeholder="price" name="price" required>
                        </div>

                        <div class="form-group col-6 my-1">
                            <label class="form-label" for="first-name-column">Manufacturing Price <sup class="text-danger">*</sup></label>
                            <input type="number" min="0.01" step="0.01" value="{{ $medicine->manufacturing_price }}" id="manufacturing_price" class="form-control" placeholder="Manufacturing Price" name="manufacturing_price" required>
                        </div>

                        <div class="form-group col-6 my-1">
                            <label class="form-label" for="first-name-column">Shelf <sup class="text-danger">*</sup></label>
                            <input type="text" id="shelf" class="form-control" value="{{ $medicine->shelf }}" placeholder="Shelf" name="shelf" required>
                        </div>

                        <div class="form-group col-6 my-1">
                            <label class="form-label" for="first-name-column">Strength <sup class="text-danger">*</sup></label>
                            <input type="text" id="strength" class="form-control" value="{{ $medicine->strength }}" placeholder="Strength" name="strength" required>
                        </div>

                        <div class="form-group col-6 my-1">
                            <label class="form-label" for="first-name-column">Price <sup class="text-danger">*</sup></label>
                            <input type="text" id="price" class="form-control" value="{{ $medicine->price }}" placeholder="price" name="price" required>
                        </div>

                        <div class="form-group col-6 my-1">
                            <label class="form-label" for="first-name-column">Category <sup class="text-danger">*</sup></label>
                            <select value="{{ $medicine->category_id }}" class="form-select" id="category" name="category_id" required>
                                @foreach($categories as $category)
                                    @if( $medicine->category_id == $category->id )
                                    <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                    @else
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-6 my-1">
                            <label class="form-label" for="first-name-column">
                                Manufacturer <sup class="text-danger">*</sup>
                            </label>
                            <select value="{{ $medicine->manufacturer_id }}" class="form-select" id="manufacturer" name="manufacturer_id"  required>
                                @foreach($manufacturers as $manufacturer)
                                    @if( $medicine->manufacturer_id == $manufacturer->id )
                                    <option value="{{ $manufacturer->id }}" selected>{{ $manufacturer->name }}</option>
                                    @else
                                    <option value="{{ $manufacturer->id }}">{{ $manufacturer->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-6 my-1">
                            <label class="form-label" for="first-name-column">
                                Unit <sup class="text-danger">*</sup>
                            </label>
                            <select value="{{ $medicine->unit_id }}" class="form-select" id="unit" name="unit_id"  required>
                                @foreach($units as $unit)
                                    @if( $medicine->unit_id == $unit->id )
                                    <option value="{{ $unit->id }}" selected>{{ $unit->name }}</option>
                                    @else
                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-6 my-1">
                            <label class="form-label" for="last-name-column">
                                Image <sup class="text-danger">*</sup>
                            </label>
                            <input type="file" id="image" class="form-control" placeholder="Image" name="image">
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
