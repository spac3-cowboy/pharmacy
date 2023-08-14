@extends("Layout.MainLayout")



@section("title", "Medicines")

@section("main")
    <div class="card shadow-none border">
        <div class="card-header bg-pitla-blue d-flex justify-content-between">
            <span>Medicine List</span>
            <a href="{{ route('medicines.create') }}" class="btn btn-success py-0">
                <i class="mdi mdi-basket-plus"></i>
                Add New
            </a>
        </div>
        <div class="card-body p-1 bordered">
            @include("ui.admin.medicine.widgets.TablePaginatedMedicineList")
        </div>
    </div>
@endsection


