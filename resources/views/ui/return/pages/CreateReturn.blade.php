@extends("Layout.MainLayout")



@section("title", "Return")

@section("main")
    <div class="card shadow-none border">
        <div class="card-header bg-pitla-blue d-flex justify-content-between">
            <span>Return</span>
        </div>
        <div class="card-body p-1 bordered">
            @include("ui.return.widgets.FormCreateReturn")
        </div>
    </div>
@endsection


