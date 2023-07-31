<?php

namespace App\Http\Controllers;

use App\Models\Medicine\Stock;
use App\Models\Purchase\Purchase;
use App\Models\Sale\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $stock_medicines = Stock::inStockProducts()->reduce(function ($total, $stock) {
            return $stock->quantity + $total;
        });
        $sales = Sale::where("created_at", Carbon::today()->toDate())->get();
        $total_sales_amount = $sales->reduce(function ($total, $sale){ return $sale->grand_total + $total; });

        $purchases = Purchase::where("created_at", Carbon::today()->toDate())->get();
        $total_purchase_amount = $purchases->reduce(function ($total, $purchase){ return $purchase->amount + $total; });

        $out_of_stocks = Stock::outOfStock();
        $expired_stocks = Stock::expiredStock();


        return view("ui.dashboard.pages.Dashboard", [
            "stock_medicines" => $stock_medicines,

            "total_sales" => $sales->count(),
            "total_sales_amount" => $total_sales_amount,
            "total_purchases" => $purchases->count(),
            "total_purchase_amount" => $total_purchase_amount,
            "out_of_stocks" => $out_of_stocks,
            "expired_stocks" => $expired_stocks,
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
}
