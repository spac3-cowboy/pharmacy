<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Medicine\Medicine;
use App\Models\Purchase\Purchase;
use App\Models\Sale\Sale;
use App\Models\Sale\SaleItem;
use App\Models\Setting\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

    public function salesReport(Request $request)
    {

        if ( $request->ajax() )
        {
            $from = date('Y-m-d', strtotime($request->from));
            $to = date('Y-m-d', strtotime($request->to));

            $query = Sale::where("business_id", Auth::user()->owned_tenant->id);
            if ( $request->exists("from") || $request->exists("to") ) {
                $query->whereBetween('created_at', [$from, $to]);
            }
            $sales = $query->get();

            $total_sales_value = $sales->reduce(function ($total, $sale){
                return $sale->grand_total + $total;
            },0);
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
                    $editUrl = route('sales.edit', [ 'sale' => $sale->id ] );
                    $destroyRoute = route('sales.destroy', [ 'sale' => $sale->id] );
                    $csrf_token = csrf_token();
                    return "<a href=\"$editUrl\" class=\"action-icon\"> <i class=\"mdi mdi-square-edit-outline\"></i></a>
                            <form class=\"d-inline-block\" id=\"customer-delete-$sale->id\" action=\"$destroyRoute\" method=\"post\">
                                <input type='hidden' name='_token' value='$csrf_token' >
                                <input type=\"hidden\" name=\"id\" value=\"$sale->id\">
                                <a href=\"javascript:void(0);\" onclick=\"deleteConfirm($sale->id)\" class=\"action-icon\"> <i class=\"mdi mdi-delete\"></i></a>
                            </form>";
                })
                ->rawColumns(["sale_id", "customer", "products", "qty", "total", "date", "invoice"])
                ->with([
                    "total_sales_value" => round($total_sales_value, 2) . Setting::key("currency")
                ])
                ->make();
        }
        return view("ui.report.pages.PaginatedSalesReport");
    }

    public function purchaseReport(Request $request)
    {

        $from = date('Y-m-d', strtotime($request->from));
        $to = date('Y-m-d', strtotime($request->to));

        $query = Purchase::where("business_id", Auth::user()->owned_tenant->id);
        if ( $request->exists("from") || $request->exists("to") ) {
            $query->whereBetween('created_at', [$from, $to]);
        }
        $purchases = $query->get();
        $total_purchase_value = $purchases->reduce(function ($total, $purchase){
            return $purchase->amount + $total;
        },0);

        if ( $request->ajax() ) {
            return DataTables::of($purchases)
                ->addColumn("medicines", function ($purchase) {
                    return $purchase->items->reduce(function ($total, $item, $i){
                        return $i+1 .". ". $item->medicine->name . "<br />";
                    },"");
                })
                ->addColumn('action', function ($purchase) {
                    $viewPurchaseUrl = route('purchases.show', [ 'id' => $purchase->id ] );
                    $editUrl = route('purchases.edit', [ 'purchase' => $purchase->id ] );
                    $destroyRoute = route('purchases.destroy', [ 'purchase' => $purchase->id] );
                    $csrf_token = csrf_token();
                    return "
                            <a href=\"$viewPurchaseUrl\" class=\"action-icon\"> <i class=\"mdi mdi-eye\"></i></a>
                            <a href=\"$editUrl\" class=\"action-icon\"> <i class=\"mdi mdi-square-edit-outline\"></i></a>
                            <form class=\"d-inline-block\" id=\"customer-delete-$purchase->id\" action=\"$destroyRoute\" method=\"post\">
                                <input type='hidden' name='_token' value='$csrf_token' >
                                <input type=\"hidden\" name=\"id\" value=\"$purchase->id\">
                                <a href=\"javascript:void(0);\" onclick=\"deleteConfirm($purchase->id)\" class=\"action-icon\"> <i class=\"mdi mdi-delete\"></i></a>
                            </form>";
                })
                ->rawColumns(["medicines", "action"])
                ->with([
                    "total_purchase_value" => round($total_purchase_value, 2) . Setting::key("currency")
                ])
                ->make();
        }
        return view("ui.report.pages.PaginatedPurchaseReport");
    }

    public function topSoldMedicines(Request $request)
    {
        $from = date('Y-m-d', strtotime($request->from));
        $to = date('Y-m-d', strtotime($request->to));

        $currency_symbol = Setting::key("currency_symbol");

        if ( $request->ajax() )
        {

            $query = SaleItem::with(["stock.medicine"])
                    ->where("business_id", Auth::user()->owned_tenant->id);
            if ( $request->exists("from") || $request->exists("to") ) {
                $query->whereBetween('created_at', [$from, $to]);
            }

            $medicines = $query->get();
            $medicines = $medicines->map(function ($si) {
                            $si->stock->medicine["grand_total"] = $si->sale->grand_total;
                            return $si->stock->medicine;
                        })
                        ->groupBy("id")
                        ->map(function ($si) {
                            $si[0]["sale"] = $si->count();
                            $si[0]["sold_amount"] = $si[0]->grand_total;
                            return $si[0];
                        });
            $total_sale_amount = $medicines->reduce(function ($total, $medicine){
                return $medicine->sold_amount + $total;
            }) . $currency_symbol;

            return DataTables::of($medicines)
                ->addColumn('sales', function ($medicine) {
                    return $medicine->sale;
                })
                ->addColumn('sold_amount', function ($medicine) use($currency_symbol) {
                    return $medicine->sold_amount . $currency_symbol;
                })
                ->addColumn('category', function ($medicine){
                    return $medicine->category->name;
                })
                ->addColumn('manufacturer', function ($medicine){
                    return $medicine->manufacturer->name;
                })
                ->addColumn('image', function ($medicine){
                    return "<img src='/$medicine->image' alt='Thumbnail'>";
                })
                ->rawColumns(['image', 'sales', 'sold_amount', 'category', 'manufacturer'])
                ->with([
                    "total_sale_amount" => $total_sale_amount
                ])
                ->make();
        }

        return view("ui.report.pages.PaginatedTopSoldMedicineReport");
    }

    public function profit(Request $request)
    {
        $from = date('Y-m-d', strtotime($request->from));
        $to = date('Y-m-d', strtotime($request->to));

        $currency_symbol = Setting::key("currency_symbol");

        if ( $request->ajax() )
        {
            $query = SaleItem::with(["stock.medicine"])
                    ->where("business_id", Auth::user()->owned_tenant->id);
            if ( $request->exists("from") || $request->exists("to") )
            {
                $query->whereBetween('created_at', [$from, $to]);
            }

            $medicines = $query->get();
            $medicines = $medicines->map(function ($si) {
                                $si->stock->medicine["grand_total"] = $si->sale->grand_total;
                                return $si->stock->medicine;
                            })
                            ->groupBy("id")
                            ->map(function ($si) {
                                $si[0]["sale"] = $si->count();
                                $si[0]["sold_amount"] = $si[0]->grand_total;
                                return $si[0];
                            });
            $sold_amount = $medicines->reduce(function ($total, $medicine) {
				                return $medicine->sold_amount + $total;
				            }) . $currency_symbol;

            return DataTables::of($medicines)
	                ->addColumn('date', function ($medicine) {
	                    return $medicine->sale;
	                })
	                ->addColumn('purchase_amount', function ($medicine) use($currency_symbol) {
	                    return $medicine->sold_amount . $currency_symbol;
	                })
	                ->addColumn('sold_amount', function ($medicine) use($currency_symbol) {
	                    return $medicine->sold_amount . $currency_symbol;
	                })
	                ->rawColumns(['month', 'sold_amount', 'purchase_amount'])
	                ->with([
	                    "sold_amount" => $sold_amount
	                ])
	                ->make();
        }

        return view("ui.report.pages.PaginatedProfitReport");
    }

}
