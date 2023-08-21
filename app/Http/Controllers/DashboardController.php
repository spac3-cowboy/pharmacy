<?php

namespace App\Http\Controllers;

use App\Models\Medicine\Stock;
use App\Models\Purchase\Purchase;
use App\Models\Return\MReturn;
use App\Models\Sale\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $sales = Sale::where("business_id", Auth::user()->owned_tenant->id)
                        ->where("created_at", Carbon::today()->toDate())
                        ->get();
        $total_sales_amount = $sales->reduce(function ($total, $sale) {
            return $sale->grand_total + $total;
        });

        $purchases = Purchase::where("business_id", Auth::user()->owned_tenant->id)
                                ->where("created_at", Carbon::today()->toDate())
                                ->get();
        $total_purchase_amount = $purchases->reduce(function ($total, $purchase) {
            return $purchase->amount + $total;
        });

        $out_of_stocks = Stock::outOfStock();
        $expired_stocks = Stock::expiredStock();

        $total_sales_today = Sale::whereDate("created_at", \Carbon\Carbon::today())->get();
        $total_sales_week = Sale::whereBetween("created_at", [\Carbon\Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
        $total_sales_month = Sale::whereBetween("created_at", [\Carbon\Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();

        $total_purchase_today = Purchase::whereDate("created_at", \Carbon\Carbon::today())->get();
        $total_purchase_week = Purchase::whereBetween("created_at", [\Carbon\Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
        $total_purchase_month = Purchase::whereBetween("created_at", [\Carbon\Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();

        $total_return_today = MReturn::whereDate("created_at", \Carbon\Carbon::today())->get();
        $total_return_week = MReturn::whereBetween("created_at", [\Carbon\Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
        $total_return_month = MReturn::whereBetween("created_at", [\Carbon\Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();

        return view("ui.dashboard.pages.Dashboard", [
            "stock_medicines" => $stock_medicines,

            "total_sales" => $sales->count(),
            "total_sales_today" => $total_sales_today->count(),
            "total_sales_week" => $total_sales_week->count(),
            "total_sales_month" => $total_sales_month->count(),


            "total_purchase_today" => $total_purchase_today->count(),
            "total_purchase_week" => $total_purchase_week->count(),
            "total_purchase_month" => $total_purchase_month->count(),

            "total_return_today" => $total_return_today->count(),
            "total_return_week" => $total_return_week->count(),
            "total_return_month" => $total_return_month->count(),

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
