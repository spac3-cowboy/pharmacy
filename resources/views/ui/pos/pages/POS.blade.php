<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>POS</title>
    <!-- Icons css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset("assets/css/pos.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/vendor/select2/css/select2.min.css") }}">

    <!---------------------- Custom CSS -------------------->
    <link href="{{ asset('/assets/css/custom.css') }}" rel="stylesheet" type="text/css" />

    @viteReactRefresh
    @vite('resources/js/Main.jsx')
</head>
<body>

    <!-- Overlay -->
    <div id="overlay" class="hide">
        <div id="loader">

        </div>
    </div>
    <!-- Overlay End -->

    <div id="app">

    </div>


    <!-- MDI Icons Demo js -->
{{--    <script src="{{ asset('assets/js/pages/demo.materialdesignicons.js') }}"></script>--}}

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.slim.min.js" integrity="sha256-tG5mcZUtJsZvyKAxYLVXrmjKBVLd6VpVccqz/r4ypFE=" crossorigin="anonymous"></script>

    <!-- Select2 js -->
    <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>

    <!-- Common Script All Across the App js -->
    <script src="{{ asset('assets/js/common.js') }}"></script>


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



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

</body>
</html>

