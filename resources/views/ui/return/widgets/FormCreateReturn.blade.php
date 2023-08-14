<div class="row justify-content-around">
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header bg-info text-white py-0">Medicine Return</div>
            <div class="card-body">
                <div class="form-group">
                    <input type="text" id="medicine-invoice" name="invoice" placeholder="Invoice Number" class="form-control form-control-sm border border-danger" />
                    <button onclick="searchMedicine()" class="btn btn-sm btn-success mt-1">Search</button>
                </div>
            </div>
        </div>
    </div>
{{--    <div class="col-lg-5">--}}
{{--        <div class="card">--}}
{{--            <div class="card-header bg-info text-white py-0">Manufacturer Return</div>--}}
{{--            <div class="card-body">--}}
{{--                <div class="form-group">--}}
{{--                    <input type="text" placeholder="Invoice Number" class="form-control form-control-sm border border-danger" />--}}
{{--                    <button class="btn btn-sm btn-success mt-1">Search</button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
</div>

<div class="row">
    <div class="col-12" id="sale-container">

    </div>

    <div class="col-12" id="return-container">

    </div>
</div>

{{------------Return Item Quantity Selector Modal-------------}}
<div id="bd-example-modal-lg" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="card">
                <div class="card-header bg-info-lighten">
                    Select Return Quantity
                </div>
                <div class="card-body my-0">
                    <div class="form-group">
                        <label for="note">Note</label>
                        <textarea class="form-control form-control-sm" name="" id="note" cols="30" rows="3"></textarea>
                    </div>
                </div>
                <div class="card-body" id="return-items-modal">

                </div>
                <div class="card-footer">
                    <button class="btn btn-danger" onclick="returnMedicine()">Confirm</button>
                    <button class="btn btn-success" onclick='$("#bd-example-modal-lg").modal("hide")'>Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
{{------------End Return Item Quantity Selector Modal-------------}}


<script>
	const searchMedicine = async () => {
		let mi = document.querySelector("#medicine-invoice");
		let res = await fetch("/dashboard/return/search-medicine?sale_id=" + mi.value).then(r => r.json());

		if ( res.msg == "success" && res.sale && res.sale.status != "partial returned" ) {
			let markup = createSaleItemsTableMarkup(res)

			document.querySelector("#sale-container").innerHTML = markup;

			// setting the modal
			let modalMarkup = `
                <ul class="list-group">
                    ${ makeLi(res.sale.items, res) }
                </ul>
            `;
			document.querySelector("#return-items-modal").innerHTML = modalMarkup;

		} else {
			document.querySelector("#sale-container").innerHTML = `
			    <h4 class="text-center">Sale Not Found</h4>
			`;
		}
	}

	const createSaleItemsTableMarkup = (res) => {
		if ( res.sale.status == "delivered" ) {
			return `<div class="card border border-primary p-0" id="sale" data-saleid="${res.sale.id}">
                    <div class="card-body">
                        ${
				res.sale.status == "delivered" || res.sale.status == "partially returned" ?
					`<h4 class="text-end">
                                    <button class="btn btn-danger" onclick="selectMedicineCount(${res.sale.id})">RETURN</button>
                                </h4>` : ""
			}
                        <table class="table border">
                            <tbody>
                                <tr class="">
                                    <th class="py-1">Sale ID : <span id="sale_id">${res.sale.id}</span></th>
                                    <th class="py-1">Total : <span id="total">${res.sale.grand_total}</span></th>
                                </tr>
                                <tr class="">
                                    <th class="py-1">Items : <span id="items">${res.sale.items.length}</span></th>
                                    <th class="py-1">Date : <span id="items">${res.sale.created_at}</span></th>
                                </tr>
                                <tr class="">
                                    <th class="py-1">Status : <span class="badge badge-danger-lighten border border-danger" id="items">${res.sale.status?.toUpperCase()}</span></th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-body py-0 my-0">
                        <table class="table">
                            <thead class="bg-dark-lighten">
                                <tr class="text-center">
                                    <th class="py-1">Medicine</th>
                                    <th class="py-1">Batch</th>
                                    <th class="py-1">Quantity</th>
                                    <th class="py-1">Price</th>
                                    <th class="py-1">Discount</th>
                                    <th class="py-1">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${makeItemsTr(res.sale.items)}
                            </tbody>
                        </table>
                    </div>
                </div>`;
		}
		else if ( res.sale.status == "partially returned" ) {
			return `<div class="card border border-primary p-0" id="sale" data-saleid="${res.sale.id}">
                    <div class="card-body">
                        ${
				res.sale.status == "delivered" || res.sale.status == "partially returned" ?
					`<h4 class="text-end">
                                    <button class="btn btn-danger" onclick="selectMedicineCount(${res.sale.id})">RETURN</button>
                                </h4>` : ""
			}
                        <table class="table border">
                            <tbody>
                                <tr class="">
                                    <th class="py-1">Sale ID : <span id="sale_id">${res.sale.id}</span></th>
                                    <th class="py-1">Total : <span id="total">${res.sale.grand_total}</span></th>
                                </tr>
                                <tr class="">
                                    <th class="py-1">Items : <span id="items">${res.sale.items.length}</span></th>
                                    <th class="py-1">Date : <span id="items">${res.sale.created_at}</span></th>
                                </tr>
                                <tr class="">
                                    <th class="py-1">Status : <span class="badge badge-danger-lighten border border-danger" id="items">${res.sale.status?.toUpperCase()}</span></th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-body py-0 my-0">
                        <table class="table">
                            <thead class="bg-dark-lighten">
                                <tr class="text-center">
                                    <th class="py-1">Medicine</th>
                                    <th class="py-1">Batch</th>
                                    <th class="py-1">Quantity</th>
                                    <th class="py-1">Price</th>
                                    <th class="py-1">Discount</th>
                                    <th class="py-1">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${makeItemsTr(res.sale.items)}
                            </tbody>
                        </table>
                    </div>
                </div>`;
		}
		else {
			return `<div class="card border border-primary p-0" id="sale" data-saleid="${res.sale.id}">
                    <div class="card-body">
                        <table class="table border">
                            <tbody>
                                <tr class="">
                                    <th class="py-1">Sale ID : <span id="sale_id">${res.sale.id}</span></th>
                                    <th class="py-1">Total : <span id="total">${res.sale.grand_total}</span></th>
                                </tr>
                                <tr class="">
                                    <th class="py-1">Items : <span id="items">${res.sale.items.length}</span></th>
                                    <th class="py-1">Date : <span id="items">${res.sale.created_at}</span></th>
                                </tr>
                                <tr class="">
                                    <th class="py-1">Status : <span class="badge badge-danger-lighten border border-danger" id="items">${res.sale.status?.toUpperCase()}</span></th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-body py-0 my-0">
                        <table class="table">
                            <thead class="bg-dark-lighten">
                                <tr class="text-center">
                                    <th class="py-1">Medicine</th>
                                    <th class="py-1">Batch</th>
                                    <th class="py-1">Quantity</th>
                                    <th class="py-1">Price</th>
                                    <th class="py-1">Discount</th>
                                    <th class="py-1">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${makeItemsTr(res.sale.items)}
                            </tbody>
                        </table>
                    </div>
                </div>`;
		}
	}

	const makeItemsTr = (items) => {
		return items.reduce((final, item) => {

			return final + `
                            <tr class="text-center">
                              <td class="py-1">${ item.stock.medicine.name }</td>
                              <td class="py-1">${ item.stock.batch }</td>
                              <td class="py-1">${ item.quantity }</td>
                              <td class="py-1">${ item.stock.mrp }</td>
                              <td class="py-1">${ item.discount }</td>
                              <td class="py-1">${ item.total   }</td>
                            </tr>
                            `;
		}, "")
	}

	const selectMedicineCount = (sale_id) => {

		$("#bd-example-modal-lg").modal("show")

		return;
		Swal.fire({
			title: 'Are You Sure?',
			showDenyButton: true,
			confirmButtonText: 'Return',
			denyButtonText: `No`,
		}).then((result) => {
			/* Read more about isConfirmed, isDenied below */
			if (result.isConfirmed) {
				let payload = new FormData();
				payload.append("_token", '{{ @csrf_token() }}');
				payload.append("sale_id", sale_id);
				fetch("/dashboard/return/medicine",{
					method: "POST",
					body: payload
				})
					.then(res => res.json())
					.then(res => {
						if( res.msg == "success" ) {
							window.location.reload();
						}
					})
			} else if (result.isDenied) {

			}
		});
	}

	const makeLi = (items, res) => {
		let title = `<li class="list-group-item py-1 bg-info-lighten">
                        <div class="bg-info-lighten d-flex text-center justify-content-around align-baseline">
                            <span class="bg-info-lighten">
                                Item
                            </span>
                            <span class="bg-info-lighten">
                                Return Quantity
                            </span>
                        </div>
                    </li>`;
		return items.reduce((total, item) => {
			if ( item.returnable_quantity == 0 ) return total;
			return total +
				`<li class="list-group-item py-1 returnable-item-li">
                                <div class="d-flex text-center justify-content-between align-baseline">
                                    <span>
                                        ${item.stock.medicine.name}
                                        <span class="badge badge-secondary-lighten returnable-item-id" data-itemid="${item.id}">${item.returnable_quantity}</span>
                                    </span>
                                    <div class="d-flex justify-content-around align-items-center">
                                        <i onclick="incrementReturnQuantity(this, ${item.returnable_quantity})" class="ri-add-circle-line cursor-pointer" style="cursor:pointer;"></i>
                                        <input type="number" value="0" min="0" max="${item.returnable_quantity}" class="returnable-item-quantity form-control form-control-sm w-50" />
                                        <i onclick="decrementReturnQuantity(this)" class="ri-indeterminate-circle-line cursor-pointer" style="cursor:pointer;"></i>
                                    </div>
                                </div>
                            </li>`;
		}, title);
	}

	const incrementReturnQuantity = (elem, max) => {
		if ( elem.nextElementSibling.value == max ) return ;
		elem.nextElementSibling.value = (elem.nextElementSibling.value - 0) + 1;
	}
	const decrementReturnQuantity = (elem) => {
		if ( elem.nextElementSibling.value == 0 ) return ;
		elem.nextElementSibling.value = elem.nextElementSibling.value - 1;
	}

	const returnMedicine = async () => {
		let sale_id = document.querySelector("#sale").dataset.saleid;
		let returnableItemsLi = [...document.querySelectorAll(".returnable-item-li")];
		let note = document.querySelector("#note").value;
		let returnableItems = returnableItemsLi.map(ri => {
			let item_id = ri.querySelector(".returnable-item-id").dataset.itemid;
			let quantity = ri.querySelector(".returnable-item-quantity").value;
			return {
				"item_id" : item_id,
				"quantity" : quantity
			}
		});

		if( !returnableItems.length ) return;

		let payload = new FormData();
		payload.append("_token", "{{ @csrf_token() }}");
		payload.append("sale_id", sale_id);
		payload.append("items", JSON.stringify(returnableItems));
		payload.append("note", note);
		let res = await fetch("/dashboard/return/medicine", {
			method: "POST",
			body: payload
		}).then(res=>res.json())

		console.log( res )

		if ( res.msg == "success" ) window.location.reload();
	}
</script>



<script>
	const searchPurchase = async () => {
		let mi = document.querySelector("#medicine-invoice");
		let res = await fetch("/dashboard/return/search-purchase?sale_id=" + mi.value).then(r => r.json());

		if ( res.msg == "success" && res.sale && res.sale.status != "partial returned" ) {
			let markup = createPurchaseItemsTableMarkup(res)

			document.querySelector("#sale-container").innerHTML = markup;

			// setting the modal
			let modalMarkup = `
                <ul class="list-group">
                    ${ makeLi(res.sale.items, res) }
                </ul>
            `;
			document.querySelector("#purchase-return-items-modal").innerHTML = modalMarkup;

		} else {
			document.querySelector("#purchase-container").innerHTML = `
			    <h4 class="text-center">Purchase Not Found</h4>
			`;
		}
	}

	const createPurchaseItemsTableMarkup = (res) => {
		if ( res.purchase.status == "delivered" ) {
			return `<div class="card border border-primary p-0" id="purchase" data-saleid="${res.purchase.id}">
                    <div class="card-body">
                        ${
				res.purchase.status == "delivered" || res.purchase.status == "partially returned" ?
					`<h4 class="text-end">
                                    <button class="btn btn-danger" onclick="selectPurchaseCount(${res.purchase.id})">RETURN</button>
                                </h4>` : ""
			}
                        <table class="table border">
                            <tbody>
                                <tr class="">
                                    <th class="py-1">Sale ID : <span id="sale_id">${res.purchase.id}</span></th>
                                    <th class="py-1">Total : <span id="total">${res.purchase.grand_total}</span></th>
                                </tr>
                                <tr class="">
                                    <th class="py-1">Items : <span id="items">${res.purchase.items.length}</span></th>
                                    <th class="py-1">Date : <span id="items">${res.purchase.created_at}</span></th>
                                </tr>
                                <tr class="">
                                    <th class="py-1">Status : <span class="badge badge-danger-lighten border border-danger" id="items">${res.purchase.status?.toUpperCase()}</span></th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-body py-0 my-0">
                        <table class="table">
                            <thead class="bg-dark-lighten">
                                <tr class="text-center">
                                    <th class="py-1">Medicine</th>
                                    <th class="py-1">Batch</th>
                                    <th class="py-1">Quantity</th>
                                    <th class="py-1">Price</th>
                                    <th class="py-1">Discount</th>
                                    <th class="py-1">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${makeItemsTrPurchase(res.purchase.items)}
                            </tbody>
                        </table>
                    </div>
                </div>`;
		}
		else if ( res.purchase.status == "partially returned" ) {
			return `<div class="card border border-primary p-0" id="sale" data-saleid="${res.purchase.id}">
                    <div class="card-body">
                        ${
				res.purchase.status == "delivered" || res.purchase.status == "partially returned" ?
					`<h4 class="text-end">
                                    <button class="btn btn-danger" onclick="selectPurchaseCount(${res.purchase.id})">RETURN</button>
                                </h4>` : ""
			}
                        <table class="table border">
                            <tbody>
                                <tr class="">
                                    <th class="py-1">Sale ID : <span id="sale_id">${res.purchase.id}</span></th>
                                    <th class="py-1">Total : <span id="total">${res.purchase.grand_total}</span></th>
                                </tr>
                                <tr class="">
                                    <th class="py-1">Items : <span id="items">${res.purchase.items.length}</span></th>
                                    <th class="py-1">Date : <span id="items">${res.purchase.created_at}</span></th>
                                </tr>
                                <tr class="">
                                    <th class="py-1">Status : <span class="badge badge-danger-lighten border border-danger" id="items">${res.purchase.status?.toUpperCase()}</span></th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-body py-0 my-0">
                        <table class="table">
                            <thead class="bg-dark-lighten">
                                <tr class="text-center">
                                    <th class="py-1">Medicine</th>
                                    <th class="py-1">Batch</th>
                                    <th class="py-1">Quantity</th>
                                    <th class="py-1">Price</th>
                                    <th class="py-1">Discount</th>
                                    <th class="py-1">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${makeItemsTr(res.purchase.items)}
                            </tbody>
                        </table>
                    </div>
                </div>`;
		}
		else {
			return `<div class="card border border-primary p-0" id="sale" data-saleid="${res.purchase.id}">
                    <div class="card-body">
                        <table class="table border">
                            <tbody>
                                <tr class="">
                                    <th class="py-1">Sale ID : <span id="sale_id">${res.purchase.id}</span></th>
                                    <th class="py-1">Total : <span id="total">${res.purchase.grand_total}</span></th>
                                </tr>
                                <tr class="">
                                    <th class="py-1">Items : <span id="items">${res.purchase.items.length}</span></th>
                                    <th class="py-1">Date : <span id="items">${res.purchase.created_at}</span></th>
                                </tr>
                                <tr class="">
                                    <th class="py-1">Status : <span class="badge badge-danger-lighten border border-danger" id="items">${res.purchase.status?.toUpperCase()}</span></th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-body py-0 my-0">
                        <table class="table">
                            <thead class="bg-dark-lighten">
                                <tr class="text-center">
                                    <th class="py-1">Medicine</th>
                                    <th class="py-1">Batch</th>
                                    <th class="py-1">Quantity</th>
                                    <th class="py-1">Price</th>
                                    <th class="py-1">Discount</th>
                                    <th class="py-1">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${makeItemsTr(res.purchase.items)}
                            </tbody>
                        </table>
                    </div>
                </div>`;
		}
	}

	const makeItemsTrPurchase = (items) => {
		return items.reduce((final, item) => {

			return final + `
                            <tr class="text-center">
                              <td class="py-1">${ item.stock.medicine.name }</td>
                              <td class="py-1">${ item.stock.batch }</td>
                              <td class="py-1">${ item.quantity }</td>
                              <td class="py-1">${ item.stock.mrp }</td>
                              <td class="py-1">${ item.discount }</td>
                              <td class="py-1">${ item.total   }</td>
                            </tr>
                            `;
		}, "")
	}

	const selectPurchaseCount = (sale_id) => {

		$("#bd-example-modal-lg").modal("show")

		return;
		Swal.fire({
			title: 'Are You Sure?',
			showDenyButton: true,
			confirmButtonText: 'Return',
			denyButtonText: `No`,
		}).then((result) => {
			/* Read more about isConfirmed, isDenied below */
			if (result.isConfirmed) {
				let payload = new FormData();
				payload.append("_token", '{{ @csrf_token() }}');
				payload.append("sale_id", sale_id);
				fetch("/dashboard/return/medicine",{
					method: "POST",
					body: payload
				})
					.then(res => res.json())
					.then(res => {
						if( res.msg == "success" ) {
							window.location.reload();
						}
					})
			} else if (result.isDenied) {

			}
		});
	}

	const makeLiPurchase = (items, res) => {
		let title = `<li class="list-group-item py-1 bg-info-lighten">
                        <div class="bg-info-lighten d-flex text-center justify-content-around align-baseline">
                            <span class="bg-info-lighten">
                                Item
                            </span>
                            <span class="bg-info-lighten">
                                Return Quantity
                            </span>
                        </div>
                    </li>`;
		return items.reduce((total, item) => {
			if ( item.returnable_quantity == 0 ) return total;
			return total +
				`<li class="list-group-item py-1 returnable-item-li">
                                <div class="d-flex text-center justify-content-between align-baseline">
                                    <span>
                                        ${item.stock.medicine.name}
                                        <span class="badge badge-secondary-lighten returnable-item-id" data-itemid="${item.id}">${item.returnable_quantity}</span>
                                    </span>
                                    <div class="d-flex justify-content-around align-items-center">
                                        <i onclick="incrementReturnQuantity(this, ${item.returnable_quantity})" class="ri-add-circle-line cursor-pointer" style="cursor:pointer;"></i>
                                        <input type="number" value="0" min="0" max="${item.returnable_quantity}" class="returnable-item-quantity form-control form-control-sm w-50" />
                                        <i onclick="decrementReturnQuantity(this)" class="ri-indeterminate-circle-line cursor-pointer" style="cursor:pointer;"></i>
                                    </div>
                                </div>
                            </li>`;
		}, title);
	}

	const incrementPurchaseReturnQuantity = (elem, max) => {
		if ( elem.nextElementSibling.value == max ) return ;
		elem.nextElementSibling.value = (elem.nextElementSibling.value - 0) + 1;
	}
	const decrementPurchaseReturnQuantity = (elem) => {
		if ( elem.nextElementSibling.value == 0 ) return ;
		elem.nextElementSibling.value = elem.nextElementSibling.value - 1;
	}

	const returnPurchase = async () => {
		let sale_id = document.querySelector("#sale").dataset.saleid;
		let returnableItemsLi = [...document.querySelectorAll(".returnable-item-li")];
		let note = document.querySelector("#note").value;
		let returnableItems = returnableItemsLi.map(ri => {
			let item_id = ri.querySelector(".returnable-item-id").dataset.itemid;
			let quantity = ri.querySelector(".returnable-item-quantity").value;
			return {
				"item_id" : item_id,
				"quantity" : quantity
			}
		});

		if( !returnableItems.length ) return;

		let payload = new FormData();
		payload.append("_token", "{{ @csrf_token() }}");
		payload.append("sale_id", sale_id);
		payload.append("items", JSON.stringify(returnableItems));
		payload.append("note", note);
		let res = await fetch("/dashboard/return/medicine", {
			method: "POST",
			body: payload
		}).then(res=>res.json())

		console.log( res )

		if ( res.msg == "success" ) window.location.reload();
	}
</script>