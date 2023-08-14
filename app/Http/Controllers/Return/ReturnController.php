<?php

namespace App\Http\Controllers\Return;

use App\Http\Controllers\Controller;
use App\Models\Medicine\Medicine;
use App\Models\Return\MReturn;
use App\Models\Return\MReturnItem;
use App\Models\Sale\Sale;
use App\Models\Sale\SaleItem;
use App\Models\Setting\Setting;
use App\Models\Tenant\Tenant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class ReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
	
	    if ( $request->ajax() ) {
		    $returns = MReturn::all();
		    return DataTables::of($returns)
			    ->addColumn("created_at", function ($return){
				    return \Carbon\Carbon::make($return->created_at)->format("d M Y");
			    })
			    ->addColumn("items", function ($return){
				    return $return->items->count();
			    })
			    ->addColumn('action', function ($return) {
				    $showUrl = route('returns.show', [ 'id' => $return->id ] );
				    $editUrl = route('returns.edit', [ 'id' => $return->id ] );
				    $destroyRoute = route('returns.destroy', [ 'id' => $return->id] );
				    $csrf_token = csrf_token();
				    return "<a href=\"$showUrl\" class=\"action-icon\"> <i class=\"mdi mdi-eye\"></i></a> ";
			    })
			    ->rawColumns(["created_at", "medicine", "action"])
			    ->make();
	    }
	    return view("ui.return.pages.PaginatedReturnList");
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
	    $returns = MReturn::with(["items"])->where("id", $id)->get();
		$sale = Sale::find($returns->first()->sale_id);
	    return view("ui.return.pages.ShowStockReturn", [
			"returns" => $returns,
		    "sale" => $sale,
		    "cs" => Setting::key("currency_symbol")
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
	
	public function searchMedicine(Request $request)
	{
		$sale = Sale::with(["items.stock.medicine"])
				->where("id", $request->sale_id)
				->first();
		$sale->items =  $sale->items->map(function ($item){
							$item->returnable_quantity = $item->returnable_quantity;
							return $item;
						});
		
		
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
		
		
		$sale = Sale::find($sale_id);
		
		$return_type = $this->checkReturnType($items);
		if ( $return_type == "error" )
		{
			return [ "msg" => "failed", "error" => "Numbers Don't Match" ];
		}
		
		if ( $return_type == "full return" )
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
				$saleItem->stock->update([
					"quantity" => $saleItem->stock->quantity + $si->quantity
				]);
			});
			$sale->update([
				"status" => "full returned"
			]);
		}
		elseif ( $return_type == "partial return" )
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
				$saleItem->stock->update([
					"quantity" => $saleItem->stock->quantity + $si->quantity
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
	
	private function checkReturnType($items): string|array
	{
		$sale_item_ids = [];
		
		$itemHashTable = [];
		foreach ($items as $item)
		{
			$sale_item_ids[] = $item->item_id;
			$itemHashTable[$item->item_id] = $item->quantity - 0;
		}
		
		$sale_items = SaleItem::with("return_items")
						->whereIn("id", $sale_item_ids)
						->get()
						->append("returnable_quantity");
		 //return [$sale_items[0]->returnable_quantity, $itemHashTable[$sale_items[0]->id]];
		
		// check if the quantity any item that is
		// being returned exceeds the amount bought
		foreach($sale_items as $sale_item)
		{
			if ( $sale_item->returnable_quantity < $itemHashTable[$sale_item->id] )
			{
				return "exceeds";
			}
		}
		$partial_return = false;
		foreach($sale_items as $sale_item)
		{
			if ( $sale_item->returnable_quantity > $itemHashTable[$sale_item->id] )
			{
				$partial_return = true;
			}
		}
		if ( $partial_return )
		{
			return "partial return";
		}
		
		
		$full_return = true;
		foreach($sale_items as $sale_item)
		{
			if ( $sale_item->returnable_quantity != $itemHashTable[$sale_item->id] )
			{
				$full_return = false;
			}
		}
		if( $full_return )
		{
			return "full return";
		}
		
		return "error";
	}
}
