<div class="row">
    <div class="col-12">
        <div class="card shadow-none border">
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
                <h4 class="card-title">Sale in Bulk</h4>
            </div>
            <div class="card-body">
                <div class="row justify-content-around">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="">Medicine</label>
                            <select autocomplete="false"  onchange="selectMedicine(this.value)" name="medicine" id="medicines" class="form-control-light form-control form-control-sm">
                            <option value="" selected>Select Medicine</option>
                            @foreach($medicines as $medicine)
                                <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="vr p-0" style="border: none; border-right: 1px dotted grey;"></div>
                    <div class="col-6">
                        <ul class="list-group ">
                            <li class="list-group-item" id="selected-medicine-name">
                                Name: <a id="medicine-name" class="">-</a>
                            </li>
                            <li class="list-group-item" id="selected-medicine-name">
                                Available Stock: <span class="badge bg-primary text-white" id="available-qty" data-available-qty="100">-</span>
                            </li>
                            <li class="list-group-item" id="selected-medicine-name">
                                Price: <span class="" id="price" data-price="100">-</span>{{ \App\Models\Setting\Setting::key('currency_symbol') }}
                            </li>
                            <li class="list-group-item" id="selected-medicine-name">
                                Available Batches: <span id="batches" class="badge bg-primary text-white">-</span>
                            </li>
                        </ul>
                        <ul class="list-group mt-2  border border-2 border-info">
                            <li class="list-group-item" id="selected-medicine-name">
                                <div class="form-group">
                                    <label for="">Select Batch <sup class="text-danger">*</sup></label>
                                    <select onclick="selectBatch(this)" name="batch" id="batch" class="form-control">
                                        <option value="-1">Batch</option>
                                    </select>
                                </div>
                            </li>
                            <li class="list-group-item" id="selected-medicine-name">
                                <div class="form-group">
                                    <label for="">Select Quantity <sup class="text-danger">*</sup></label>
                                    <div class="d-flex justify-content-start align-items-center">
                                        <i onclick="increaseQty()" class="uil uil-plus-circle mx-2" style="cursor: pointer"></i>
                                        <input oninput="updateQty()" id="qty" type="number" step="1" min="0" max="1" class=" w-25 form-control form-control-sm">
                                        <i onclick="decreaseQty()" class="uil uil-minus-circle mx-2" style="cursor: pointer"></i>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item" id="selected-medicine-name">
                                <div class="form-group">
                                    <label for="">Price Total</label>
                                    <div class="d-flex justify-content-start align-items-center">
                                        <input id="price-total" type="number" step="1" min="0" max="1" class="w-50 form-control form-control-sm form-control-light" disabled>{{ \App\Models\Setting\Setting::key('currency_symbol') }}
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item" id="selected-customer-name">
                                <div class="form-group">
                                    <label for="">Customer</label>
                                    <select name="customer" id="customer" class="form-control-light form-control form-control-sm">
                                        <option value="-1">Walkaway Customer</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </li>
                            <li class="list-group-item" id="selected-customer-name">
                                <div class="form-group">
                                    <label for="">Paid</label>
                                    <input type="number" min="0" step="0.01" id="paid" value="0" class="form-control form-control-sm">
                                </div>
                            </li>

                        </ul>
                        <button onclick="sale()" class="btn btn-success mt-2">
                            Sale
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@section("styles")
    <link rel="stylesheet" href="{{ asset("assets/vendor/select2/css/select2.min.css") }}">
@endsection

@section("scripts")

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.slim.min.js" integrity="sha256-tG5mcZUtJsZvyKAxYLVXrmjKBVLd6VpVccqz/r4ypFE=" crossorigin="anonymous"></script>

    <!-- Select2 js -->
    <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>

    <script type="text/javascript">
	    $(document).ready(function() {
	        $('#medicines').select2({
	            theme: "classic"
	        });
	    });
    </script>
@endsection


<script>
    const currency_symbol = "{{ \App\Models\Setting\Setting::key('currency_symbol') }}"
	const qty = document.querySelector("#qty");
	const availableQty = document.querySelector("#available-qty");
	const price = document.querySelector("#price");
	const batch = document.querySelector("#batch");
	const batcheCount = document.querySelector("#batches");
	const priceTotal = document.querySelector("#price-total");
	const customer = document.querySelector("#customer");
	const medicine = document.querySelector("#medicines");
	const paid = document.querySelector("#paid");

    const selectMedicine = (mid) => {
	    fetch("/dashboard/medicines/"+mid, {
		    headers: {
			    "X-Requested-With": "XMLHttpRequest"
            }
        })
        .then(r => r.json())
        .then(r => {
	        console.log(r)
            document.querySelector("#medicine-name").innerHTML = r.medicine.name;
	        batcheCount.innerHTML = r.medicine.stocks.length;
			let options = r.medicine.stocks.map(s=>{
				console.log(s.batch)
                return `<option value="${s.batch}" data-stock="${s.id}" data-price="${s.mrp}" data-qty="${s.quantity}">${s.batch}</option>`;
            })
            .reduce((total, batch)=>{
                return total + batch;
            },0)
	        console.log(options)
	        batch.innerHTML = options
        })
    }
	const increaseQty = () => {
		if( qty.value == availableQty.dataset.availableQty ) return;


		qty.value = qty.value - 0 + 1;

		priceTotal.value = qty.value * price.innerHTML;
		paid.value = qty.value * price.innerHTML;
	}
	const decreaseQty = () => {
	    if( qty.value == 1 ) return;

		qty.value = qty.value - 1;
		priceTotal.value = qty.value * price.innerHTML;
		paid.value = qty.value * price.innerHTML;
	}
	const updateQty = () => {
		if( qty.value < 1 ) return;

		priceTotal.value = qty.value * price.innerHTML;
		paid.value = qty.value * price.innerHTML;
	}

	const sale = () => {
	    if ( qty.value == 0 ) return;
		if ( batch.value == -1 ) return;
		Swal.fire({
			title: 'Confirm',
			showDenyButton: true,
			confirmButtonText: 'Yes',
			denyButtonText: `Cancel`,
		})
        .then(async (result) => {
			/* Read more about isConfirmed, isDenied below */
			if (result.isConfirmed) {
				let payload = new FormData();
				payload.append("_token", '{{ @csrf_token() }}');
				payload.append("customer_id", customer.value);
				payload.append("medicine_id", medicine.value);
				payload.append("stock_id", medicine.value);
				payload.append("quantity", qty.value);
				payload.append("batch", batch.value);
				payload.append("stock_id", getSelectedBatch(batch)?.dataset?.stock);
				payload.append("paid", paid.value);
                let res = await fetch("/dashboard/sales/bulk", {
                              method: "POST",
                              body: payload
                          }).then(res=>res.json());
                if( res.msg == "success" ) {
					Swal.fire({
                        title: "Sale Successful",
                        description: "",
                        icon: "success"
                    }).then(()=>{
						window.location.reload();
                    });


                } else {
	                Swal.fire({
		                title: "Sale Failed",
		                description: "",
		                icon: "error"
	                });
                }
			}
		})
	}

	const selectBatch = (selectNode) => {
		let selectedOption = getSelectedBatch(batch);
        availableQty.innerHTML = selectedOption.dataset.qty
        price.innerHTML = selectedOption.dataset.price
		priceTotal.value = qty.value * selectedOption.dataset.price;
		paid.value = qty.value * selectedOption.dataset.price;
	}

	const getSelectedBatch = (selectNode) => {
		return selectNode.options[selectNode.selectedIndex];
	}

</script>