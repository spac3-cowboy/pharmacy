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
                {{ auth()->user()->name }}
            </div>
            <div class="card-body">

            </div>
        </div>
    </div>
</div>
