<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Models\Sale\Sale;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ( $request->ajax() ) {
            $sales = Sale::where("business_id", Auth::user()->owned_tenant->id)->get();
            return DataTables::of($sales)
                ->addColumn("sale_id", function ($sale){
                    return "INV" . $sale->id;
                })
                ->addColumn("customer", function ($sale){
                    if ( $sale->customer_id ) {
                        return $sale->customer->name;
                    }
                    return "Walkway Customer";
                })
                ->addColumn("products", function ($sale){
                    $items = "";
                    return $sale->items->reduce(function ($final, $item){
                        return $final . $item->stock->medicine->name . "<br />";
                    },"");
                })
                ->addColumn("qty", function ($sale){
                    return $sale->total_quantity;
                })
                ->addColumn("total", function ($sale){
                    return $sale->total;
                })
                ->addColumn("date", function ($sale){
                    return $sale->created_at;
                })
                ->addColumn("invoice", function ($sale){
                    $viewInvoiceUrl = route("sales.invoice", [ "sale" => $sale->id ]);
                    return "<a href=\"$viewInvoiceUrl\" class=\"btn btn-secondary text-white action-icon\"> <i class=\"uil uil-invoice\"></i></a>";
                })
                ->addColumn('action', function ($sale) {
					return "";
                    $editUrl = route('sales.edit', [ 'sale' => $sale->id ] );
                    $destroyRoute = route('sales.destroy', [ 'sale' => $sale->id] );
                    $csrf_token = csrf_token();
                    return "
                           <form class=\"d-inline-block\" id=\"customer-delete-$sale->id\" action=\"$destroyRoute\" method=\"post\">
                                <input type='hidden' name='_token' value='$csrf_token' >
                                <input type=\"hidden\" name=\"id\" value=\"$sale->id\">
                                <a href=\"javascript:void(0);\" onclick=\"deleteConfirm($sale->id)\" class=\"action-icon\"> <i class=\"mdi mdi-delete\"></i></a>
                            </form>";
                })
                ->rawColumns(["sale_id", "customer", "products", "qty", "total", "date", "invoice", "action"])
                ->make();
        }
        return view("ui.sale.pages.PaginatedSalesList");
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


    public function invoice(string $sale)
    {
        $sale = Sale::find($sale);
        if ( !$sale ) return redirect()->back();

        return view("ui.sale.pages.Invoice", [
            "sale" => $sale
        ]);
    }
}
