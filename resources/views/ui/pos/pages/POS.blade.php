<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>POS</title>
    <!-- Icons css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <script src="https://code.jquery.com/jquery-3.7.0.slim.min.js" integrity="sha256-tG5mcZUtJsZvyKAxYLVXrmjKBVLd6VpVccqz/r4ypFE=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="{{ asset("assets/css/pos.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/vendor/select2/css/select2.min.css") }}">
</head>
<body>
    <div class="container">
        <div class="product-container" id="left">
            <div class="product-controls">
                <div class="search-box">
                    <span class="search-icon">
                        <i class="uil uil-search-alt"></i>
                    </span>
                    <input type="text" placeholder="Search Here" id="search-box-input">
                    <span class="qr-icon">
                        <i class="mdi mdi-qrcode-scan"></i>
                    </span>
                </div>
                <div class="selectors">
                    <select name="category" id="category" class="category">
                        <option value="">Category</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <select name="vendor" id="vendor">
                        <option value="">Select Vendor</option>
                        @foreach($vendors as $vendor)
                            <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="products-container">
                @foreach($stocks as $stock)
                <div class="product">
                    <div class="product-image">
                        <img src="/assets/images/medicine/{{ $stock->medicine->image }}" alt="Image">
                    </div>
                    <div class="product-title">{{ $stock->medicine->name }}</div>
                    <div class="product-price">
                        <span class="badge">
                            {{ $stock->mrp }} taka
                        </span>
                    </div>
                    <div class="product-add-button">
                        <button onclick="add({{ $stock->medicine_id }})">Add</button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div  id="right">
            <div id="customer-section">
                <button id="add-customer-button">
                    <i class="mdi mdi-account-plus"></i>
                    Add New Customer
                </button>
                <select name="customer" id="customer" class="customer">
                    <option value="">Customer</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                    @endforeach
                </select>
                <a href="{{ route('dashboard') }}">
                    <button id="dashboard-button">
                        <i class="mdi mdi-desktop-mac"></i>
                    </button>
                </a>
            </div>
            <div id="cash-register">
                <div id="added-product-list-container">
                    <table>
                        <thead>
                        <tr>
                            <th>MEDICINE</th>
                            <th>BATCH</th>
                            <th>EXPIRY</th>
                            <th>QUANTITY</th>
                            <th>PRICE</th>
                            <th>DISCOUNT %</th>
                            <th>TOTAL</th>
                            <th>
                                <i class="mdi mdi-delete"></i>
                            </th>
                        </tr>
                        </thead>
                        <tbody id="tbody">

                        </tbody>
                    </table>
                </div>
                <div id="calculations-container"></div>
            </div>
        </div>
    </div>



    <!-- MDI Icons Demo js -->
    <script src="{{ asset('assets/js/pages/demo.materialdesignicons.js') }}"></script>

    <!-- Select2 js -->
    <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>


    <script type="text/javascript">
        $(document).ready(function() {
            $('#category').select2({
                theme: "classic"
            });
        });
        $(document).ready(function() {
            $('#vendor').select2({
                theme: "classic"
            });
        });
        $(document).ready(function() {
            $('#customer').select2();
        });
    </script>

    <script type="text/javascript">
        const remove = (id) => {
            console.log(id)
            document.querySelector("#"+id).remove();
        }

        const add = (medicine_id) => {
            let payload = new FormData();
            payload.append("medicine_id", medicine_id);
            payload.append("_token", '{{ @csrf_token() }}');


            fetch("/dashboard/pos/add-to-cart", {
                method: "POST",
                body: payload
            })
            .then(r => r.json())
            .then(r => {
                let tr = `<table>
                              <tr style="font-size: 16px" id="tr-${r.stock.id}">
                                <td>${r.stock.medicine.name}</td>
                                <td>
                                    ${makeBatchSelect(r.batches)}
                                </td>
                                <td>${r.stock.expiry_date}</td>
                                <td>
                                    <input type="number" value="1" style="width:3em">
                                </td>
                                <td>500.00</td>
                                <td>0</td>
                                <td>485</td>
                                <td style="color: red;">
                                    <i onclick="remove('tr-${r.stock.id}')" class="mdi mdi-close"></i>
                                </td>
                            </tr>
                        </table>`
                tr = (new DOMParser().parseFromString(tr, "text/html")).querySelector("tr");
                let tbody = document.querySelector("#added-product-list-container #tbody");
                tbody.append(tr);
            });
        }

        const makeBatchSelect = (batches) => {
            let select = `
                <select>
            `;
            batches.forEach(batch=>{
                select += `<option value="${batch}">${batch}</option>`;
            });

            select += `</select>`

            return select;
        }
    </script>
</body>
</html>

