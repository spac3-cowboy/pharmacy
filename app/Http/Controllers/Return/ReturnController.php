<?php

namespace App\Http\Controllers\Return;

use App\Http\Controllers\Controller;
use App\Models\Return\MReturn;
use App\Models\Return\MReturnItem;
use App\Models\Sale\Sale;
use App\Models\Sale\SaleItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("ui.return.pages.CreateReturn");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
	
	public function searchMedicine(Request $request)
	{
		$sale = Sale::with(["items.stock.medicine"])
				->where("id", $request->sale_id)
				->first();
		
		$returns = MReturn::with(["items"])
					->where("sale_id", $sale->id)
					->get();
		
		if ( $sale )
		{
			$sale->created_at = Carbon::make($sale->created_at)->format("d/m/Y");
		}
		return [ "msg" => "success", "sale" => $sale, "returns" => $returns ];
	}
	
	public function searchManufacturer(Request $request)
	{
	
	}
	
	public function returnMedicine(Request $request)
	{
		$sale_id = $request->sale_id;
		$items = collect(json_decode($request->items));
		$item_ids = $items->map(function ($item) {
								return $item->item_id;
							})->toArray();
		
		$all_sale_item   = SaleItem::whereIn("id", $item_ids)
									->get()
									->reduce(function ($total, $saleItem) {
										return $total + $saleItem->quantity;
									}) ?? 0;
		$all_return_items = MReturn::with(["items"])
							->where("sale_id", $sale_id)
							->get()
							->map(function ($mr) { return $mr->items; })
							->flatten();
		
		$all_current_return_item = $items->reduce(function ($total, $item) {
										return $total + $item->quantity;
									}) ?? 0;
		
		
		$sale = Sale::find($sale_id);
		
		$rtype = $this->checkReturnType($items);
		
		if ( $rtype == "full return" )
		{
			$return = MReturn::create([
						"business_id" => Auth::user()->owned_tenant->id,
						"sale_id" => $sale->id,
						"total" => $sale->grand_total,
						"note" => $request->note
					 ]);
			// return completely
			$items->each(function ($si) use($return) {
				$saleItem = SaleItem::find($si->item_id);
				MReturnItem::create([
					"business_id" => Auth::user()->owned_tenant->id,
					"return_id" => $return->id,
					"stock_id" => $saleItem->stock_id,
					"sale_item_id" => $si->item_id,
					"quantity" => $si->quantity,
					"total" => $saleItem->mrp * $si->quantity
				]);
			});
			$sale->update([
				"status" => "full returned"
			]);
		}
		elseif ( $rtype == "partial return" )
		{
			//return [$all_sale_item, $all_return_item, $all_current_return_item];
			// return partially
			$return = MReturn::create([
				"business_id" => Auth::user()->owned_tenant->id,
				"sale_id" => $sale->id,
				"total" => $sale->grand_total,
				"note" => $request->note
			]);
			// return completely
			$items->each(function ($si) use($return) {
				$saleItem = SaleItem::find($si->item_id);
				MReturnItem::create([
					"business_id" => Auth::user()->owned_tenant->id,
					"return_id" => $return->id,
					"stock_id" => $saleItem->stock_id,
					"sale_item_id" => $si->item_id,
					"quantity" => $si->quantity,
					"total" => $saleItem->mrp * $si->quantity
				]);
			});
			$sale->update([
				"status" => "partially returned"
			]);
		}
		else
		{
			return [ "msg" => "failed", "error" => "amount doesn't match" ];
		}
		
		
		
		return [ "msg" => "success" ];
	}
	
	private function checkReturnType($items): string
	{
		$sale_item_ids = $items->map(function ($item) {
							return $item->item_id;
						 })->toArray();
		
		foreach ($sale_item_ids as $id) {
		
		}
		
		
		return "exceeds";
	}
}
