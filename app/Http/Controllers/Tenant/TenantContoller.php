<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTenantRequest;
use App\Http\Requests\Tenant\UpdateTenantRequest;
use App\Models\Category\Category;
use App\Models\Manufacturer\Manufacturer;
use App\Models\Medicine\Medicine;
use App\Models\Medicine\Stock;
use App\Models\Purchase\Purchase;
use App\Models\Sale\Sale;
use App\Models\Setting\Setting;
use App\Models\Tenant\Tenant;
use App\Models\User;
use App\Models\Vendor\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class TenantContoller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ( $request->ajax() ) {
            $tenants = Tenant::all();
            return DataTables::of($tenants)
                ->addColumn("created_at", function ($tenant){
                    return \Carbon\Carbon::make($tenant->created_at)->format("d M Y");
                })
                ->addColumn("user", function ($tenant){
                    return $tenant->owner->name;
                })
                ->addColumn('action', function ($tenant) {
                    $showUrl = route('admin.tenants.show', [ 'tenant' => $tenant->id ] );
                    $editUrl = route('admin.tenants.edit', [ 'tenant' => $tenant->id ] );
                    $destroyRoute = route('admin.tenants.destroy', [ 'tenant' => $tenant->id] );
                    $csrf_token = csrf_token();
                    return "
                            <a href=\"$showUrl\" class=\"action-icon\"> <i class=\"mdi mdi-eye\"></i></a>
                            <a href=\"$editUrl\" class=\"action-icon\"> <i class=\"mdi mdi-square-edit-outline\"></i></a>
                            ";
                })
                ->rawColumns(["created_at", "user", "action"])
                ->make();
        }
        return view("ui.tenant.pages.PaginatedTenantsList");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("ui.tenant.pages.CreateTenant");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTenantRequest $request)
    {
        $userData = $request->only([
            "name",
            "phone",
            "email",
            "address",
            "bg"
        ]);
        $userData["password"] = Hash::make($request->get("password"));

	    $file = $request->file("tenant_image");
	    $destinationPath = 'assets/images/';
	    $filename = Str::random() .".".  $file->getClientOriginalExtension();
	    $file->move($destinationPath, $filename);
	    $userData["image"] = $filename;

        $r = DB::transaction(function () use($userData, $request, $filename) {
            $user = User::create($userData);
            $tenantData = $request->only([
                "name",
                "address",
                "email",
                "phone",
            ]);
            $tenantData["user_id"] = $user->id;

            $tenant = Tenant::create($tenantData);

			Setting::create([
				"business_id" => $tenant->id,
				"key" => "logo",
				"value" => "default_site_logo.png"
			]);
			Setting::create([
				"business_id" => $tenant->id,
				"key" => "vat",
				"value" => "15"
			]);

			Category::insert([
				["business_id" => $tenant->id, "name" => "ট্যাবলেট", "image" => "default_category_image"],
				["business_id" => $tenant->id, "name" => "সিরাপ", "image" => "default_category_image"],
				["business_id" => $tenant->id, "name" => "ইঞ্জেকশন", "image" => "default_category_image"],
				["business_id" => $tenant->id, "name" => "মলম", "image" => "default_category_image"],
				["business_id" => $tenant->id, "name" => "পাউডার", "image" => "default_category_image"],
			]);

            return true;
        });

        if ( $r ) {
            return redirect()->route("admin.tenants.index")->with([
                "msg" => "New Tenant Created"
            ]);
        }
        return redirect()->route("tenants.index")->withErrors([
            "msg" => "Failed"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tenant = Tenant::find($id);
        $categories = Category::where("business_id", $id)->get();
        $medicines = Medicine::where("business_id", $id)->get();
        $manufacturers = Manufacturer::where("business_id", $id)->get();
        $vendors = Vendor::where("business_id", $id)->get();
        $stocks = Stock::where("business_id", $id)->get();
        $purchases = Purchase::where("business_id", $id)->get();
        $sales = Sale::where("business_id", $id)->get();
        $customers = User::where("business_id", $id)
                     ->where("user_type", 4)
                     ->get();

        return view("ui.tenant.pages.ShowTenant", [
            "tenant" => $tenant,
            "categories" => $categories,
            "medicines" => $medicines,
            "manufacturers" => $manufacturers,
            "vendors" => $vendors,
            "stocks" => $stocks,
            "purchases" => $purchases,
            "sales" => $sales,
            "customers" => $customers
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
		$tenant = Tenant::find($id);
	    return view("ui.tenant.pages.EditTenant", [
			"tenant" => $tenant
	    ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTenantRequest $request, string $id)
    {
        // update business details
	    $tenantData = $request->only([
		    "name",
		    "address",
		    "email",
		    "phone",
	    ]);
		$tenant = Tenant::find($id);
		$tenant->update($tenantData);

		// updating user data
	    $userData = $request->only([
		    "name",
		    "phone",
		    "email",
		    "address",
		    "bg"
	    ]);
		if ( $request->get("password") ) {
	        $userData["password"] = Hash::make($request->get("password"));
		}
	    $user = $tenant->owner->update($userData);

		return redirect()->route("tenants.index")->with("msg", "Tenant Data Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
