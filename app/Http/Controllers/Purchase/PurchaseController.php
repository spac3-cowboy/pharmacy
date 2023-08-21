<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Models\Manufacturer\Manufacturer;
use App\Models\Medicine\Medicine;
use App\Models\Medicine\Stock;
use App\Models\Purchase\Purchase;
use App\Models\Purchase\PurchaseItem;
use App\Models\Sale\Sale;
use App\Models\Vendor\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $purchases = Purchase::where("business_id", Auth::user()->owned_tenant->id)->get();

        if ( $request->ajax() )
		{
            return DataTables::of($purchases)
                    ->addColumn("medicines", function ($purchase) {
                        return $purchase->items->reduce(function ($total, $item, $i){
                            return $i+1 .". ". $item->medicine->name . "<br />";
                        },"");
                    })
                    ->addColumn('action', function ($purchase) {
                        $viewPurchaseUrl = route('purchases.show', [ 'id' => $purchase->id ] );
                        $editUrl = route('purchases.edit', [ 'purchase' => $purchase->id ] );
                        $destroyRoute = route('purchases.destroy', [ 'purchase' => $purchase->id] );
                        $csrf_token = csrf_token();
						if ( $purchase->sale ) {
							return "
                                <a href=\"$viewPurchaseUrl\" class=\"action-icon\"> <i class=\"mdi mdi-eye\"></i></a>
                                <a href=\"$editUrl\" class=\" hide action-icon\"> <i class=\"mdi mdi-square-edit-outline\"></i></a>
                               ";
						}
                    })
                    ->rawColumns(["medicines", "action"])
                    ->make();
        }
        return view("ui.purchase.pages.PaginatedPurchases", [
            "purchases" => $purchases
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $manufacturers = Manufacturer::where("business_id", Auth::user()->owned_tenant->id)->get();
        return view("ui.purchase.pages.CreatePurchase", [
            "manufacturers" => $manufacturers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $items = $request->items;
        $purchase_date = $request->t["purchase_date"];
        $paid = $request->t["paid"];
        $amount = collect($items)->reduce(function ($total, $item) {
                        return $total + (($item["mrp"] * $item["quantity"]) - $item["flat_discount"] );
                  });


        DB::transaction(function () use($items, $amount, $purchase_date, $paid) {

            $purchase = Purchase::create([
			                "purchase_date" => $purchase_date,
			                "amount" => $amount,
			                "paid" => $paid,
			                "business_id" => Auth::user()->owned_tenant->id
			            ]);

            foreach ($items as $item)
            {
                $purchaseItem = PurchaseItem::create([
				                    "purchase_id" => $purchase->id,
				                    "medicine_id" => $item["medicine_id"],
				                    "batch" => $item["batch"],
				                    "quantity" => $item["quantity"],
				                    "manufacturing_date" => $item["manufacturing_date"],
				                    "manufacturer_id" => $item["manufacturer_id"] ?? null,
				                    "vendor_id" => $item["vendor_id"] ?? null,
				                    "expiry_date" => $item["expiry_date"],
				                    "mrp" => $item["mrp"],
				                    "buy_price" => $item["buy_price"],
				                    "flat_discount" => $item["flat_discount"],
				                    "business_id" => Auth::user()->owned_tenant->id
				                ]);


                $batch = $item["batch"];
                $cost = $item["quantity"] * $item["buy_price"];
                $tmpStock = Stock::where("batch", $batch)->first();
                if ( !$tmpStock )
                {
                    Stock::create([
                        "purchase_id" => $purchaseItem->id,
                        "medicine_id" => $item["medicine_id"],
                        "quantity" => $item["quantity"],
                        "manufacturer_id" => $manufacturer_id ?? null,
	                    "vendor_id" => $vendor_id ?? null,
	                    "manufacturing_date" => $item["manufacturing_date"],
                        "expiry_date" => $item["expiry_date"],
                        "batch" => $batch,
                        "mrp" => $item["mrp"],
                        "buy_price" => $item["buy_price"],
                        "cost" => $cost,
                        "business_id" => Auth::user()->owned_tenant->id
                    ]);
                }
                else
                {
                    // Presuming that stock of same batch will surely
                    // have same expiry and manufacturing dates.
                    $tmpStock->quantity = $tmpStock->quantity + $item["quantity"];
                    $tmpStock->save();
                }
            }
        });



        return [ "msg" => "success" ];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $purchase = Purchase::with(["items.medicine"])
                    ->where("id", $id)
                    ->where("business_id", Auth::user()->owned_tenant->id)
                    ->first();
//        dd($purchase->items);
        return view("ui.purchase.pages.ShowPurchase", [
            "purchase" => $purchase
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function getPageData()
    {
        $manufacturers = Manufacturer::where("business_id", Auth::user()->owned_tenant->id)->get();
        $vendors = Vendor::where("business_id", Auth::user()->owned_tenant->id)->get();
        $medicines = Medicine::with(["manufacturer"])
                     ->where("business_id", Auth::user()->owned_tenant->id)
//	                 ->orWhere("globally_visible", true)
                     ->get();
        return [
            "msg" => "success",
            "manufacturers" => $manufacturers,
            "vendors" => $vendors,
            "medicines" => $medicines
        ];
    }

}
