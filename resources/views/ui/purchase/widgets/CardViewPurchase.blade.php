<div class="card">
    <div class="card-header py-1 d-flex justify-content-between ">
        <div class="card w-50 shadow-none">
            <div class="card-body border p-1">
                <h3>Purchase ID: #{{ $purchase->id }}</h3>
                <h5>
                    Purchase Date: {{ \Carbon\Carbon::make($purchase->purchase_date)->format("d/m/Y") }}
                </h5>
                <h5>
                    Amount: {{ $purchase->amount }}<small class="fst-italic ">{{ App\Models\Setting\Setting::key("currency_symbol") }}</small>
                </h5>
                <h5>
                    Paid: {{ $purchase->paid }}<small class="fst-italic">{{ App\Models\Setting\Setting::key("currency_symbol") }}</small>
                </h5>
                <h5>
                    Due: {{ $purchase->amount - $purchase->paid }}<small class="fst-italic">{{ App\Models\Setting\Setting::key("currency_symbol") }}</small>
                </h5>
            </div>
        </div>
        <span>
            <a href="{{ route('purchases.index') }}" class="btn btn-primary shadow-none">Purchase List</a>
            <a href="{{ route('purchases.create') }}" class="btn btn-success shadow-none">
                <i class="mdi mdi-basket-plus"></i>
                New Purchase
            </a>
        </span>
    </div>
    <div class="card-body">
        <table class="table table-stripped">
            <thead class="bg-pitla-blue py-1">
                <tr class=" py-1">
                    <th class=" py-1">Medicine Name</th>
                    <th class=" py-1">Batch</th>
                    <th class=" py-1">Manufacturing Date</th>
                    <th class=" py-1">Expiry Date</th>
                    <th class=" py-1">MRP Per Unit</th>
                    <th class=" py-1">Buy Price Per Unit</th>
                    <th class=" py-1">Quantity</th>
                    <th class=" py-1">Flat Discount</th>
                    <th class=" py-1">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchase->items as $item)
                <tr>
                    <td>{{ $item->medicine->name }}</td>
                    <td>{{ $item->batch }}</td>
                    <td>{{ $item->manufacturing_date }}</td>
                    <td>{{ $item->expiry_date }}</td>
                    <td>{{ $item->mrp }}</td>
                    <td>{{ $item->buy_price }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->flat_discount }}</td>
                    <td>{{ $item->quantity * $item->buy_price }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
