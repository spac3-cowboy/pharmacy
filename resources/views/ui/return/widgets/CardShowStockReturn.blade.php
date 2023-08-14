<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table>
                    <tbody class="table">
                        <tr>
                            <td class="pb-1"><strong>Sale Date</strong></td>
                            <td class="pb-1"><strong class="badge text-dark">{{ $sale->created_at }}</strong></td>
                        </tr>
                        <tr>
                            <td class="pb-1"><strong>Sale ID</strong></td>
                            <td class="pb-1"><strong class="badge text-dark">{{ $sale->id }}</strong></td>
                        </tr>
                        <tr>
                            <td class="pb-1"><strong>Grand Total </strong></td>
                            <td class="pb-1"><strong class="badge text-dark">{{ $sale->grand_total }}{{ $cs }}</strong></td>
                        </tr>
                        <tr>
                            <td class="pb-1"><strong>Total Paid</strong></td>
                            <td class="pb-1"><strong class="badge text-dark">{{ $sale->paid }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-8">
        @foreach($returns as $r)
        <div class="card p-1 shadow-none border">
            <div class="card-body p-1 bg-light bg-light-lighten">
                <strong class="badge badge-primary-lighten">
                    Returned Date: {{ $r->created_at }}
                </strong>
                <table class="table">
                    <thead class="bg-secondary-lighten">
                        <tr>
                            <th>#</th>
                            <th>Medicine</th>
                            <th>Returned Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($r->items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->stock->medicine->name }}</td>
                            <td>{{ $item->quantity }}</td>
                        </tr>
                    </tbody>
                    @endforeach
                </table>
            </div>
        </div>
        @endforeach
    </div>
</div>
