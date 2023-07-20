<?php

namespace App\Http\Controllers\Medicine;

use App\Http\Controllers\Controller;
use App\Models\Medicine\Stock;
use Illuminate\Http\Request;

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

    public function inStock()
    {
        $stocks = Stock::where("")->get();
        return view("ui.stock.pages.PaginatedInStock");
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
