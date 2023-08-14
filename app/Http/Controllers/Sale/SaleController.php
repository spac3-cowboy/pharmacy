<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Models\Cart\Cart;
use App\Models\Medicine\Medicine;
use App\Models\Medicine\Stock;
use App\Models\Sale\Sale;
use App\Models\Sale\SaleItem;
use App\Models\Setting\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
                ->addColumn("qty", function ($sale){
                    return $sale->total_quantity;
                })
                ->addColumn("total", function ($sale){
                    return $sale->total;
                })
                ->addColumn("paid", function ($sale){
                    return $sale->paid;
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
	
	public function bulk()
	{
		$medicines = Medicine::where("business_id", Auth::user()->owned_tenant->id)->get();
		$customers = User::customers();
		return view("ui.sale.pages.BulkSale", [
			"medicines" => $medicines,
			"customers" => $customers
		]);
	}
	
	public function bulkSale(Request $request)
	{
		
		$customer_id = $request->customer_id;
		if ( $customer_id == -1 )
		{
			$customer_id = null;
		}
		$total_quantity = $request->quantity;
		$stock = Stock::find($request->stock_id);
		
		
		$sub_total = $total_quantity * $stock->mrp;
		$flat_discount = 0;
		
		//$vat = Setting::key("vat") ?? 0;
		// adding vat
		$grand_total = ($sub_total);
		
		// subtracting flat discount
		$grand_total = $grand_total - $flat_discount;
		
		//$vat_amount = $sub_total * ((Setting::key("vat"))/100);
		$vat_amount = 0;
		
		$due = (round($grand_total - $request->paid));
		// if paid more than billed amount
		$due = $due < 0 ? 0 : $due;
		$paid = $request->paid;
		
		$sale = DB::transaction(function () use($stock, $total_quantity, $vat_amount, $sub_total, $flat_discount, $grand_total, $paid, $due, $customer_id) {
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
			
			SaleItem::create([
				"sale_id" => $sale->id,
				"stock_id" => $stock->id,
				"quantity" => $stock->quantity,
				"discount" => $flat_discount,
				"business_id" => Auth::user()->owned_tenant->id,
				"total" => $grand_total
			]);
			
			// reducing the stock amount
			$stock->update([
				"quantity" => $stock->quantity - $total_quantity
			]);
			
			
			return $sale;
		});
		
		if ( $sale ) {
			return [
				"msg" => "success",
				"sale" => $sale
			];
		}
		
		return [
			"msg" => "failed"
		];
	}
}
