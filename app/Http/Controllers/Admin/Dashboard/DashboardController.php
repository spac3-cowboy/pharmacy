<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		DB::statement("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
		$query = "select
		    sum(si.quantity) as sold,
		    sum(si.total) as amount,
		    m.name as name
		from sale_items si
		    join stocks on stocks.id = si.stock_id
		    join medicines m on stocks.medicine_id = m.id
		group by name";
		$top_sold_medicines = DB::select($query);
		return view("ui.admin.dashboard.pages.Dashboard", [
			"top_sold_medicines" => $top_sold_medicines
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
