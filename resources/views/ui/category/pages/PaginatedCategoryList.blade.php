@extends("Layout.MainLayout")



@section("title", "Categories")

@section("main")
    <div class="card shadow-none border">
        <div class="card-header bg-pitla-blue d-flex justify-content-between">
            <span>Category List</span>
            <a class="btn btn-success py-0" href="{{ route('categories.create') }}">Add New</a>
        </div>
        <div class="card-body p-0 bordered">
            @include("ui.category.widgets.TablePaginatedCategoryList")
        </div>
    </div>
@endsection


