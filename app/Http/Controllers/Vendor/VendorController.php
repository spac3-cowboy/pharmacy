<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Manufacturer\Manufacturer;
use App\Models\Vendor\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ( $request->ajax() ) {
            $vendors = Vendor::where("business_id", Auth::user()->owned_tenant->id)->get();
            return DataTables::of($vendors)
                ->addColumn('purchases', function ($vendor){
                    return $vendor->purchases->count();
                })
                ->addColumn('action', function ($vendor){
                    $editUrl = route('vendors.edit', [ 'vendor' => $vendor->id] );
                    $destroyRoute = route('vendors.destroy', [ 'vendor' => $vendor->id] );
                    $csrf_token = csrf_token();
                    return "<a href=\"$editUrl\" class=\"action-icon\"> <i class=\"mdi mdi-square-edit-outline\"></i></a>
                            <form class=\"d-inline-block\" id=\"customer-delete-$vendor->id\" action=\"$destroyRoute\" method=\"post\">
                                <input type='hidden' name='_token' value='$csrf_token' >
                                <input type=\"hidden\" name=\"id\" value=\"$vendor->id\">
                                <a href=\"javascript:void(0);\" onclick=\"deleteConfirm($vendor->id)\" class=\"action-icon\"> <i class=\"mdi mdi-delete\"></i></a>
                            </form>";
                })
                ->rawColumns(['medicine', 'action'])
                ->make();
        }
        return view("ui.vendor.pages.PaginatedVendorList");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("ui.vendor.pages.CreateVendor");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Vendor::create([
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            "address" => $request->address,
            "business_id" => Auth::user()->owned_tenant->id
        ]);

        return redirect()->route("vendors.index");
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
