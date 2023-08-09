<?php

namespace App\Http\Controllers\Transfer;

use App\Http\Controllers\Controller;
use App\Models\Medicine\Medicine;
use App\Models\Medicine\Stock;
use App\Models\Stock\Transfer;
use App\Models\Tenant\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
	
	    if ( $request->ajax() ) {
		    $transfers = Transfer::all();
		    return DataTables::of($transfers)
			    ->addColumn("date", function ($transfer) {
				    return \Carbon\Carbon::make($transfer->created_at)->format("d M Y");
			    })
			    ->addColumn("transfer_id", function ($transfer) {
				    return $transfer->id;
			    })
			    ->addColumn("medicine", function ($transfer) {
				    return Stock::find($transfer->stock_id)->medicine->name ?? "";
			    })
			    ->addColumn('action', function ($transfer) {
				    $showUrl = route('tenants.show', [ 'tenant' => $transfer->id ] );
				    $editUrl = route('tenants.edit', [ 'tenant' => $transfer->id ] );
				    $destroyRoute = route('tenants.destroy', [ 'tenant' => $transfer->id] );
				    $csrf_token = csrf_token();
				    return "
                            <a href=\"$editUrl\" class=\"action-icon\"> <i class=\"mdi mdi-square-edit-outline\"></i></a>
                            <form class=\"d-inline-block\" id=\"tenant-delete-$transfer->id\" action=\"$destroyRoute\" method=\"post\">
                                <input type='hidden' name='_token' value='$csrf_token' >
                                <input type=\"hidden\" name=\"id\" value=\"$transfer->id\">
                                <a href=\"javascript:void(0);\" onclick=\"deleteConfirm($transfer->id)\" class=\"action-icon\"> <i class=\"mdi mdi-delete\"></i></a>
                            </form>";
			    })
			    ->rawColumns(["date", "transfer_id", "medicine", "action"])
			    ->make();
	    }
	    return view("ui.transfer.pages.PaginatedSalesList");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
	    $medicines = Medicine::where("business_id", Auth::user()->owned_tenant->id)->get();
	    $customers = User::customers();
	    return view("ui.stock.pages.Transfer", [
		    "medicines" => $medicines,
		    "customers" => $customers
	    ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
		$stock = Stock::find($request->stock_id);
	    $customer_id = $request->customer_id;
		if ( $customer_id == -1 ) {
			$customer_id = null;
		}
		
		$t = DB::transaction(function () use($stock, $request, $customer_id) {
			$t = Transfer::create([
				"business_id" => Auth::user()->owned_tenant->id,
				"total_quantity" => $request->quantity,
				"sub_total" => $request->quantity * $stock->mrp,
				"grand_total" => $request->quantity * $stock->mrp,
				"paid" => 0,
				"note" => $request->note,
				"customer_id" => $customer_id,
				"stock_id" => $request->stock_id,
				"batch" => $request->batch
			]);
			$stock->update([
				"quantity" => $stock->quantity - $request->quantity
			]);
			return $t;
		});
		if ( $t ) {
			return [ "msg" => "success" ];
		}
	
	    return [ "msg" => "failed" ];
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
