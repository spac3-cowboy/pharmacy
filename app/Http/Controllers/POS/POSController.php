<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\Category\Category;
use App\Models\Medicine\Stock;
use App\Models\User;
use Illuminate\Http\Request;

class POSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        $vendors = Category::all();
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
        $stocks = Stock::with(["medicine"])
                    ->where("medicine_id", $request->medicine_id)
                    ->get();
        $batches = $stocks->map(function ($stock){
            return $stock->batch;
        })->toArray();
        return [ "msg" => "success", "stock" => $stocks->first(), "batches" => $batches ];
    }
}
