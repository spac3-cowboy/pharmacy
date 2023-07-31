@extends("Layout.MainLayout")



@section("title", "Tenants")

@section("main")
    <div class="card shadow-none border">
        <div class="card-header bg-pitla-blue d-flex justify-content-between">
            <span>Tenants History</span>
        </div>
        <div class="card-body p-1 bordered">
            @include("ui.tenant.widgets.CardShowTenant")
        </div>
    </div>
@endsection


