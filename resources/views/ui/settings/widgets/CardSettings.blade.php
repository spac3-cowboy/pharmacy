<div class="card shadow-none">
    <div class="card-header py-1">
        Update Settings
    </div>
    <div class="card-body">
        <div class="form-group d-flex">
            <label for="" class="mx-2 w-25">APP NAME : </label>
            <input type="text" class="form-control w-50" id="app_name" value="{{ \App\Models\Setting\Setting::key('app_name') }}" />
            <button class="btn btn-success mx-2 w-25" onclick="updateKey('app_name')">UPDATE</button>
        </div>
        <hr />
        <div class="form-group d-flex">
            <label for="" class="mx-2 w-25">APP PHONE : </label>
            <input type="text" class="form-control w-50" id="app_phone" value="{{ \App\Models\Setting\Setting::key("app_phone") }}" />
            <button class="btn btn-success mx-2 w-25" onclick="updateKey('app_phone')">UPDATE</button>
        </div>
        <hr />
        <div class="form-group d-flex">
            <label for="" class="mx-2 w-25">APP EMAIL : </label>
            <input type="text" class="form-control w-50" id="app_email" value="{{ \App\Models\Setting\Setting::key("app_email") }}" />
            <button class="btn btn-success mx-2 w-25" onclick="updateKey('app_email')">UPDATE</button>
        </div>
        <hr />
        <div class="form-group d-flex">
            <label for="" class="mx-2 w-25">CURRENCY NAME : </label>
            <input type="text" class="form-control w-50" id="currency" value="{{ \App\Models\Setting\Setting::key("currency") }}" />
            <button class="btn btn-success mx-2 w-25" onclick="updateKey('currency')">UPDATE</button>
        </div>
        <hr />
        <div class="form-group d-flex justify-content-start">
            <label for="" class="mx-2 w-25">CURRENCY SYMBOL : </label>
            <input type="text" class="form-control w-50" id="currency_symbol" value="{{ \App\Models\Setting\Setting::key("currency_symbol") }}" />
            <button class="btn btn-success mx-2 w-25" onclick="updateKey('currency_symbol')">UPDATE</button>
        </div>
        <hr />

        <div class="form-group d-flex justify-content-start">
            <label for="" class="mx-2 w-25">TAX (%) : </label>
            <input type="text" class="form-control w-50" id="vat" value="{{ \App\Models\Setting\Setting::key("vat") }}" />
            <button class="btn btn-success mx-2 w-25"  onclick="updateKey('vat')">UPDATE</button>
        </div>
        <hr />

        <div class="form-group d-flex justify-content-start">
            <label for="" class="mx-2 w-25">Invoice Bottom Text : </label>
            <textarea cols="1" rows="2" type="text" class="form-control w-50" id="invoice-bottom-text">
                {{ \App\Models\Setting\Setting::key("invoice-bottom-text") }}
            </textarea>
            <button class="btn btn-success mx-2 w-25"  onclick="updateKey('invoice-bottom-text')">UPDATE</button>
        </div>
        <hr />

        <div class="form-group d-flex justify-content-start">
            <label for="" class="mx-2 w-25">  </label>
            <div class="w-50 text-center">
                <img id="logo-image-preview" style="width: 150px; height: 150px;" class="img-thumbnail d-inline-block" src="/assets/images/{{ \App\Models\Setting\Setting::key("logo") }}" alt="">
            </div>
            <button class="btn btn-success mx-2 w-25" style="visibility: hidden"></button>
        </div>

        <div class="form-group d-flex justify-content-start mt-2">
            <label for="" class="mx-2 w-25"> Logo : </label>
            <input onchange="previewImage()" type="file" id="logo-image" name="image"  class="form-control w-50" id="vat" value="{{ \App\Models\Setting\Setting::key("logo") }}" />
            <button class="btn btn-success mx-2 w-25"  onclick="updateLogo()">UPDATE</button>
        </div>
    </div>
</div>


<script>
    function previewImage() {
	    let logoImage = document.querySelector("#logo-image").files[0];
	    let logoImagePreview = document.querySelector("#logo-image-preview");
	    logoImagePreview.src = URL.createObjectURL(logoImage)
	}

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

    function updateLogo() {

	    let _token = document.querySelector('meta[name="csrf-token"]').content;
	    let logoImage = document.querySelector("#logo-image").files[0];

	    let payload = new FormData();
	    payload.append("key", "logo");
	    payload.append("image", logoImage);
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
