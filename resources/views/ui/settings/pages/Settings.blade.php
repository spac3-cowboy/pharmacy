@extends("Layout.MainLayout")



@section("title", "Settingsk")

@section("main")
    <div class="card shadow-none border">
        <div class="card-header bg-pitla-blue d-flex justify-content-between">
            <span>Settings</span>
        </div>
        <div class="card-body p-1 bordered">
            @include("ui.settings.widgets.CardSettings")
        </div>
    </div>
@endsection


