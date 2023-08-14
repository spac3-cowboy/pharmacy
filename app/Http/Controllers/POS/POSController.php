<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Http\Requests\POS\PayRequest;
use App\Models\Cart\Cart;
use App\Models\Category\Category;
use App\Models\Medicine\Stock;
use App\Models\Sale\Sale;
use App\Models\Sale\SaleItem;
use App\Models\Setting\Setting;
use App\Models\User;
use App\Models\Vendor\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class POSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::where("business_id",  Auth::user()->owned_tenant->id)->get();
        $vendors = Vendor::where("business_id",  Auth::user()->owned_tenant->id)->get();
        $stocks = Stock::inStockProducts();
        $customers = User::customers();
//        dd($stocks);
        return view("ui.pos.pages.POS", [
            "categories" => $categories,
            "vendors" => $vendors,
            "stocks" => $stocks,
            "customers" => $customers
        ]);
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


    public function addToCart(Request $request)
    {
        $stock = Stock::with(["medicine"])
                    ->where("medicine_id", $request->medicine_id)
                    ->first();

        $cart = Cart::where("medicine_id", $request->medicine_id)->first();

        if ( $cart )
        {
            return [ "msg" => "failed", "error" => "Already Added" ];
        }
        else
        {
            $cart = Cart::create([
                "medicine_id" => $request->medicine_id,
                "quantity" => 1,
                "discount" => 0,
                "business_id" => Auth::user()->owned_tenant->id
            ]);
        }

        $carts = $this->getCarts();

        return [ "msg" => "success", "carts" => $carts ];
    }

    private function getCarts() {
        return Cart::with(["stock.medicine", "medicine"])
                ->where("business_id", Auth::user()->owned_tenant->id)
                ->get()
                ->map(function ($cart) {
                    $batches = Stock::select(["batch", "expiry_date"])
                                ->where("medicine_id", $cart->medicine_id)
                                ->where("business_id", Auth::user()->owned_tenant->id)
                                ->whereDate("expiry_date", ">", Carbon::today()->toDateString())
                                ->where("quantity", ">", 0)
                                ->get()
                                ->pluck("batch")
                                ->toArray();
                    $cart["batches"] = $batches;

                    return $cart;
                });
    }

    public function increaseQuantity(Request $request)
    {
        $cart = Cart::find($request->cart_id);

        $stock = Stock::with(["medicine"])
                ->where("medicine_id", $cart->stock->medicine_id)
                ->where("batch", $request->batch)
                ->where("business_id", Auth::user()->owned_tenant->id)
                ->first();

        if ( !$stock || !$cart )
        {
            return [ "msg" => "failed" ];
        }
        if ( $stock->quantity == $cart->quantity )
        {
            return [ "msg" => "failed", "error" => "Max Limit Reached" ];
        }
        $cart->quantity = $cart->quantity + 1;
        $cart->save();

        return [ "msg" => "success", "carts" => $this->getCarts() ];
    }

    public function decreaseQuantity(Request $request)
    {

        $cart = Cart::find($request->cart_id);
        $stock = Stock::with(["medicine"])
                ->where("medicine_id", $cart->stock->medicine_id)
                ->where("batch", $request->batch)
                ->where("business_id", Auth::user()->owned_tenant->id)
                ->first();

        if ( !$stock || !$cart )
        {
            return [ "msg" => "failed" ];
        }

        $cart->quantity = $cart->quantity - 1;
        $cart->save();
        if ( $cart->quantity == 0 )
        {
            $cart->delete();
        }

        return [ "msg" => "success", "carts" => $this->getCarts() ];
    }

    public function removeFromCart(Request $request)
    {
        $cart = Cart::find($request->cart_id);
        if ( $cart ) {
            $cart->delete();
        }

        $carts = Cart::with(["stock.medicine", "medicine"])
                ->where("business_id", Auth::user()->owned_tenant->id)
                ->get()
                ->map(function ($cart) use($request) {
                    $batches = Stock::select("batch")
                        ->where("medicine_id", $cart->medicine_id)
                        ->where("business_id", Auth::user()->owned_tenant->id)
                        ->get()
                        ->pluck("batch")
                        ->toArray();
                    $cart["batches"] = $batches;

                    return $cart;
                });

        return [ "msg" => "success", "carts" => $carts ];
    }

    public function resetCart()
    {
        Cart::where("business_id", Auth::user()->owned_tenant->id)
            ->get()
            ->each(function ($cart){
                $cart->delete();
            });
        $carts = Cart::with(["stock.medicine", "medicine"])
            ->where("business_id", Auth::user()->owned_tenant->id)
            ->get()
                ->map(function ($cart) {
                    $batches = Stock::select("batch")
                        ->where("medicine_id", $cart->medicine_id)
                        ->where("business_id", Auth::user()->owned_tenant->id)
                        ->get()
                        ->pluck("batch")
                        ->toArray();
                    $cart["batches"] = $batches;

                    return $cart;
                });
        return [ "msg" => "success", "carts" => $carts ];
    }


    public function selectBatch(Request $request)
    {
        $cart = Cart::where("id", $request->cart_id)->first();
        $stock = Stock::where("batch", $request->batch)
                 ->where("business_id", Auth::user()->owned_tenant->id)
                 ->first();
        $cart->update([
            "batch" => $request->batch,
            "stock_id" => $stock->id,
            "quantity" => 1
        ]);
        $cart->save();
        $carts = $this->getCarts();

        return [ "msg" => "success", "carts" => $carts ];
    }

    public function getPageData()
    {
        $categories = Category::where("business_id", Auth::user()->owned_tenant->id)->get();
        $vendors = Vendor::where("business_id", Auth::user()->owned_tenant->id)->get();;
        $stocks = Stock::inStockProducts();
        $customers = User::customers();

        $carts = Cart::with(["stock.medicine", "medicine"])
                ->where("business_id", Auth::user()->owned_tenant->id)
                ->get()
                ->map(function ($cart) {
                    $batches = Stock::select("batch")
                        ->where("medicine_id", $cart->medicine_id)
                        ->where("business_id", Auth::user()->owned_tenant->id)
                        ->get()
                        ->pluck("batch")
                        ->toArray();
                    $cart["batches"] = $batches;

                    return $cart;
                });

        return [
            "msg" => "success",
            "categories" => $categories,
            "vendors" => $vendors,
            "stocks" => $stocks,
            "customers" => $customers,
            "carts" => $carts,
            "vat" => Setting::key("vat") ?? 0,
        ];
    }


    public function searchStocks(Request $request)
    {
        $key = $request->q;
        $cat_id = $request->cat_id;
        $ven_id = $request->ven_id;
        $stocks = Stock::inStockProducts($key, $cat_id, $ven_id);
        return [
            "msg" => "success",
            "stocks" => $stocks
        ];
    }

    public function pay(PayRequest $request)
    {
        $customer_id = $request->customer_id;
        if ( $customer_id == -1 )
        {
            $customer_id = null;
        }
        $carts = Cart::with(["stock"])
	                 ->where("business_id", Auth::user()->owned_tenant->id)
	                 ->get();
		
        $total_quantity = $carts->reduce(function ($total, $cart) {
            return $total + $cart->quantity;
        });
        $sub_total = $carts->reduce(function ($total, $cart) {
            $tmp = ($cart->quantity * $cart->stock->mrp);
            $tmp = $tmp - ($tmp * ($cart->discount/100) );
            return $total + $tmp;
        });
        $flat_discount = $request->discount;
	
	    $vat = ( is_numeric(Setting::key("vat")) ? Setting::key("vat") : 0 );
		
        // adding vat
	    if ( $vat != 0 ) {
            $grand_total = ($sub_total * ( 1 + ( $vat / 100 ) ));
	    } else {
	        $grand_total = $sub_total;
	    }
			
		
        // subtracting flat discount
        $grand_total = $grand_total - $flat_discount;
	
	    if ( $vat != 0 ) {
            $vat_amount = $sub_total * ($vat/100);
	    } else {
            $vat_amount = 0;
	    }

        $due = (($grand_total - $request->paid));
        // if paid more than billed amount
	    if ( !$due ) {
            $due = 0;
	    }
        $paid = $request->paid;


        $sale = DB::transaction(function () use($carts, $total_quantity, $vat_amount, $sub_total, $flat_discount, $grand_total, $paid, $due, $customer_id) {
            $sale = Sale::create([
                "total_quantity" => $total_quantity,
                "sub_total" => $sub_total,
                "flat_discount" => $flat_discount,
                "vat_amount" => $vat_amount,
                "grand_total" => $grand_total,
                "paid" => $paid,
                "due" => $due,
                "customer_id" => $customer_id,
                "business_id" => Auth::user()->owned_tenant->id
            ]);

            $carts->each(function ($cart) use($sale){
	            $tmp = ($cart->quantity * $cart->stock->mrp);
	            $total = $tmp - ( $tmp * ($cart->discount/100) );
                SaleItem::create([
                    "sale_id" => $sale->id,
                    "stock_id" => $cart->stock->id,
                    "quantity" => $cart->quantity,
                    "discount" => $cart->discount,
					"total" => $total,
                    "business_id" => Auth::user()->owned_tenant->id
                ]);
            });

            // reducing the stock amount
            $carts->each(function ($cart){
                $cart->stock->update([
                    "quantity" => $cart->stock->quantity - $cart->quantity
                ]);
            });

            Cart::where("business_id", Auth::user()->owned_tenant->id)
	                ->get()
	                ->each(function ($cart){
	                    $cart->delete();
	                });

            return $sale;
        });

        if ( $sale ) {
            return [
                "msg" => "success",
                "sale" => $sale,
                "carts" => $this->getCarts(),
                "stocks" => Stock::inStockProducts()
            ];
        }

        return [
            "msg" => "failed"
        ];
    }

    public function setDiscount(Request $request)
    {
        $cart = Cart::find($request->cart_id);
        $cart->update([
            "discount" => $request->discount
        ]);

        return [ "msg" => "success", "carts" => $this->getCarts() ];
    }
}
