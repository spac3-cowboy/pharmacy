<?php

namespace App\Http\Controllers\Medicine;

use App\Http\Controllers\Controller;
use App\Models\Medicine\Stock;
use Illuminate\Http\Request;
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
        $stocks = Stock::inStockProducts();
        if ( $request->ajax() ) {
            return DataTables::of($stocks)
                    ->addColumn("name", function ($stock){
                        return $stock->medicine->name;
                    })
                    ->addColumn("generic_name", function ($stock){
                        return $stock->medicine->generic_name;
                    })
                    ->addColumn("strength", function ($stock){
                        return $stock->medicine->generic_name;
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
                    ->addColumn("manufacturer", function ($stock){
                        return $stock->manufacturer->name;
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
                        'manufacturer',
                        'action'
                    ])
                    ->make();
        }
        return view("ui.stock.pages.PaginatedInStock", [
            "stocks" => $stocks
        ]);
    }
    public function outOfStock()
    {
        return view("ui.stock.pages.PaginatedInStock");
    }
    public function emergencyStock()
    {
        return view("ui.stock.pages.PaginatedInStock");
    }
    public function expiredStock()
    {
        return view("ui.stock.pages.PaginatedInStock");
    }
    public function toBeExpired()
    {
        return view("ui.stock.pages.PaginatedInStock");
    }
}
