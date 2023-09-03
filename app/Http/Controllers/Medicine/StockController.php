<?php

namespace App\Http\Controllers\Medicine;

use App\Http\Controllers\Controller;
use App\Models\Medicine\Stock;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("ui.stock.pages.PaginatedInStock");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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

    public function inStock(Request $request)
    {
        $key = $request->get("key");
        $cat_id = $request->get("cat_id");

        $stocks = Stock::with(["medicine.category", "manufacturer"])
						->whereDate("expiry_date", ">", Carbon::today()->toDateString())
						->where("quantity", ">",     0)
						->where("business_id", Auth::user()->owned_tenant->id)
						->whereHas("medicine", function($query) use($key, $cat_id) {
							if ( $key ) {
								$query->where("name", "like", "%$key%");
							}
							if ( $cat_id ) {
								$query->where("category_id", $cat_id);
							}
						})
						->get();


        if ( $request->ajax() )
		{
            return DataTables::of($stocks)
                    ->addColumn("name", function ($stock){
                        return $stock->medicine->name;
                    })
                    ->addColumn("generic_name", function ($stock){
                        return $stock->medicine->generic_name;
                    })
                    ->addColumn("strength", function ($stock){
                        return $stock->medicine->strength;
                    })
                    ->addColumn("shelf", function ($stock){
                        return $stock->medicine->shelf;
                    })
                    ->addColumn("avl_qty", function ($stock){
                        return $stock->quantity;
                    })
                    ->addColumn("buy_price", function ($stock){
                        return $stock->quantity;
                    })
                    ->addColumn("purchase_date", function ($stock){
                        return $stock->created_at;
                    })
                    ->addColumn("bought_from", function ($stock){
						if ( $stock->manufacturer ) {
                            return $stock->manufacturer->name;
						}
						if ( $stock->vendor ) {
                            return $stock->manufacturer->name;
						}
                    })
                    ->addColumn("price", function ($stock){
                        return $stock->mrp;
                    })
                    ->addColumn("emergency", function ($stock){
                        return $stock->emergency ? "<span class='badge badge-danger-lighten'>YES<span>" : "<span class='badge badge-secondary-lighten'>NO<span>";
                    })
                    ->rawColumns([
                        'name',
                        'generic_name',
                        'strength',
                        'shelf',
                        'avl_qty',
                        'purchase_date',
                        'price',
                        'bought_from',
                        'emergency',
                        'action'
                    ])
                    ->make();
        }
        return view("ui.stock.pages.PaginatedInStock", [
            "stocks" => $stocks
        ]);
    }
    public function outOfStock(Request $request)
    {

        $key = $request->get("key");
        $cat_id = $request->get("cat_id");

        $stocks = Stock::with(["medicine.category", "manufacturer"])
            ->whereDate("expiry_date", ">", Carbon::today()->toDateString())
            ->where("quantity", "<",     1)
            ->where("business_id", Auth::user()->owned_tenant->id)
            ->whereHas("medicine", function($query) use($key, $cat_id) {
                if ( $key ) {
                    $query->where("name", "like", "%$key%");
                }
                if ( $cat_id ) {
                    $query->where("category_id", $cat_id);
                }
            })
            ->get();
        if ( $request->ajax() ) {
            return DataTables::of($stocks)
                ->addColumn("name", function ($stock){
                    return $stock->medicine->name;
                })
                ->addColumn("generic_name", function ($stock){
                    return $stock->medicine->generic_name;
                })
                ->addColumn("strength", function ($stock){
                    return $stock->medicine->strength;
                })
                ->addColumn("shelf", function ($stock){
                    return $stock->medicine->shelf;
                })
                ->addColumn("avl_qty", function ($stock){
                    return $stock->quantity;
                })
                ->addColumn("buy_price", function ($stock){
                    return $stock->quantity;
                })
                ->addColumn("purchase_date", function ($stock){
                    return $stock->created_at;
                })
	            ->addColumn("bought_from", function ($stock){
		            if ( $stock->manufacturer ) {
			            return $stock->manufacturer->name;
		            }
		            if ( $stock->vendor ) {
			            return $stock->manufacturer->name;
		            }
	            })
                ->addColumn("price", function ($stock){
                    return $stock->mrp;
                })
                ->rawColumns([
                    'name',
                    'generic_name',
                    'strength',
                    'shelf',
                    'avl_qty',
                    'purchase_date',
                    'price',
                    'bought_from',
                    'action'
                ])
                ->make();
        }

        return view("ui.stock.pages.PaginatedOutOfStock");
    }
    public function emergencyStock()
    {
        return view("ui.stock.pages.PaginatedInStock");
    }
    public function expiredStock(Request $request)
    {

        $key = $request->get("key");
        $cat_id = $request->get("cat_id");

        $stocks = Stock::with(["medicine.category", "manufacturer"])
            ->whereDate("expiry_date", "<", Carbon::today()->toDateString())
            ->where("quantity", ">",     0)
            ->where("business_id", Auth::user()->owned_tenant->id)
            ->whereHas("medicine", function($query) use($key, $cat_id) {
                if ( $key ) {
                    $query->where("name", "like", "%$key%");
                }
                if ( $cat_id ) {
                    $query->where("category_id", $cat_id);
                }
            })
            ->get();
        if ( $request->ajax() ) {
            return DataTables::of($stocks)
                ->addColumn("name", function ($stock){
                    return $stock->medicine->name;
                })
                ->addColumn("generic_name", function ($stock){
                    return $stock->medicine->generic_name;
                })
                ->addColumn("strength", function ($stock){
                    return $stock->medicine->strength;
                })
                ->addColumn("shelf", function ($stock){
                    return $stock->medicine->shelf;
                })
                ->addColumn("avl_qty", function ($stock){
                    return $stock->quantity;
                })
                ->addColumn("buy_price", function ($stock){
                    return $stock->quantity;
                })
                ->addColumn("purchase_date", function ($stock){
                    return $stock->created_at;
                })
	            ->addColumn("bought_from", function ($stock){
		            if ( $stock->manufacturer ) {
			            return $stock->manufacturer->name;
		            }
		            if ( $stock->vendor ) {
			            return $stock->manufacturer->name;
		            }
	            })
                ->addColumn("price", function ($stock){
                    return $stock->mrp;
                })
                ->rawColumns([
                    'name',
                    'generic_name',
                    'strength',
                    'shelf',
                    'avl_qty',
                    'purchase_date',
                    'price',
                    'bought_from',
                    'action'
                ])
                ->make();
        }
        return view("ui.stock.pages.PaginatedExpiredStock");
    }
    public function toBeExpired(Request $request)
    {

        $key = $request->get("key");
        $cat_id = $request->get("cat_id");

        $stocks = Stock::with(["medicine.category", "manufacturer"])
            ->whereDate("expiry_date", "<", Carbon::today()->subDays(30)->toDateString())
            ->where("quantity", ">",     0)
            ->where("business_id", Auth::user()->owned_tenant->id)
            ->whereHas("medicine", function($query) use($key, $cat_id) {
                if ( $key ) {
                    $query->where("name", "like", "%$key%");
                }
                if ( $cat_id ) {
                    $query->where("category_id", $cat_id);
                }
            })
            ->get();
        if ( $request->ajax() ) {
            return DataTables::of($stocks)
                ->addColumn("name", function ($stock){
                    return $stock->medicine->name;
                })
                ->addColumn("generic_name", function ($stock){
                    return $stock->medicine->generic_name;
                })
                ->addColumn("strength", function ($stock){
                    return $stock->medicine->strength;
                })
                ->addColumn("shelf", function ($stock){
                    return $stock->medicine->shelf;
                })
                ->addColumn("avl_qty", function ($stock){
                    return $stock->quantity;
                })
                ->addColumn("buy_price", function ($stock){
                    return $stock->quantity;
                })
                ->addColumn("purchase_date", function ($stock){
                    return $stock->created_at;
                })
	            ->addColumn("bought_from", function ($stock){
		            if ( $stock->manufacturer ) {
			            return $stock->manufacturer->name;
		            }
		            if ( $stock->vendor ) {
			            return $stock->manufacturer->name;
		            }
	            })
                ->addColumn("price", function ($stock){
                    return $stock->mrp;
                })
                ->rawColumns([
                    'name',
                    'generic_name',
                    'strength',
                    'shelf',
                    'avl_qty',
                    'purchase_date',
                    'price',
                    'bought_from',
                    'action'
                ])
                ->make();
        }
        return view("ui.stock.pages.PaginatedToBeExpiredStock");
    }


	public function transferPage()
	{
		return view("ui.stock.pages.Transfer");
	}
}
