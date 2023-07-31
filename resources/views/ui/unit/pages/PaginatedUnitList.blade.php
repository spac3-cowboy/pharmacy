@extends("Layout.MainLayout")



@section("title", "Units")

@section("main")
    <div class="card shadow-none border">
        <div class="card-header bg-pitla-blue d-flex justify-content-between">
            <span>Unit List</span>
            <a class="btn btn-success py-0" href="{{ route('units.create') }}">Add New</a>
        </div>
        <div class="card-body p-0 bordered">
            @include("ui.unit.widgets.TablePaginatedUnitList")
        </div>
    </div>
@endsection


