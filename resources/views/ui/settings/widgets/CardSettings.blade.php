<div class="card">
    <div class="card-header py-1">
        Settings
    </div>
    <div class="card-body">
        <div class="form-group d-flex">
            <label for="" class="mx-2">APP NAME: </label>
            <input type="text" class="form-control" id="app_name" value="{{ \App\Models\Setting\Setting::key('app_name') }}" />
            <button class="btn btn-success mx-2" onclick="updateKey('app_name')">UPDATE</button>
        </div>
        <hr />
        <div class="form-group d-flex">
            <label for="" class="mx-2">APP PHONE: </label>
            <input type="text" class="form-control" id="app_phone" value="{{ \App\Models\Setting\Setting::key("app_phone") }}" />
            <button class="btn btn-success mx-2" onclick="updateKey('app_phone')">UPDATE</button>
        </div>
        <hr />
        <div class="form-group d-flex">
            <label for="" class="mx-2">APP EMAIL: </label>
            <input type="text" class="form-control" id="app_email" value="{{ \App\Models\Setting\Setting::key("app_email") }}" />
            <button class="btn btn-success mx-2" onclick="updateKey('app_email')">UPDATE</button>
        </div>
        <hr />

        <div class="form-group d-flex">
            <label for="" class="mx-2">TAX: </label>
            <input type="text" class="form-control" id="vat" value="{{ \App\Models\Setting\Setting::key("vat") }}" />
            <button class="btn btn-success mx-2"  onclick="updateKey('vat')">UPDATE</button>
        </div>
    </div>
</div>


<script>
    function updateKey(key) {

        let _token = document.querySelector('meta[name="csrf-token"]').content;
        let value = document.querySelector("#"+key).value;
        console.log(document.querySelector("#"+key).value)
        let payload = new FormData();
        payload.append("key", key);
        payload.append("value", value);
        payload.append("_token", _token);
        TurnOverlayOn();
        fetch("/dashboard/settings/update",{
            method: "POST",
            body: payload
        })
        .then(r => r.json())
        .then(data => {
            console.log(data)
            TurnOverlayOff();
            if ( data.msg == "success" ) {
                Swal.fire({
                    "title": "success",
                    "description": "Updated",
                    "icon": "success"
                });
            }
        });
    }
</script>
