<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTenantRequest;
use App\Models\Category\Category;
use App\Models\Manufacturer\Manufacturer;
use App\Models\Medicine\Medicine;
use App\Models\Medicine\Stock;
use App\Models\Purchase\Purchase;
use App\Models\Sale\Sale;
use App\Models\Setting\Setting;
use App\Models\Tenant\Tenant;
use App\Models\User;
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
                    $showUrl = route('tenants.show', [ 'tenant' => $tenant->id ] );
                    $editUrl = route('tenants.edit', [ 'tenant' => $tenant->id ] );
                    $destroyRoute = route('tenants.destroy', [ 'tenant' => $tenant->id] );
                    $csrf_token = csrf_token();
                    return "
                            <a href=\"$showUrl\" class=\"action-icon\"> <i class=\"mdi mdi-eye\"></i></a>
                            <a href=\"$editUrl\" class=\"action-icon\"> <i class=\"mdi mdi-square-edit-outline\"></i></a>
                            <form class=\"d-inline-block\" id=\"tenant-delete-$tenant->id\" action=\"$destroyRoute\" method=\"post\">
                                <input type='hidden' name='_token' value='$csrf_token' >
                                <input type=\"hidden\" name=\"id\" value=\"$tenant->id\">
                                <a href=\"javascript:void(0);\" onclick=\"deleteConfirm($tenant->id)\" class=\"action-icon\"> <i class=\"mdi mdi-delete\"></i></a>
                            </form>";
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

        $r = DB::transaction(function () use($userData, $request){
            $user = User::create($userData);
            $tenantData = $request->only([
                "name",
                "address",
                "email",
                "phone",
            ]);
            $tenantData["user_id"] = $user->id;

            Tenant::create($tenantData);
			
	        $file = $request->file("tenant_image");
	        $destinationPath = 'assets/images/';
	        $filename = Str::random() .".".  $file->getClientOriginalExtension();
	        $file->move($destinationPath, $filename);
			
			Setting::create([
				"business_id" => Auth::user()->owned_tenant->id,
				"key" => "logo",
				"value" => $filename
			]);
			
            return true;
        });

        if ( $r ) {
            return redirect()->route("tenants.index")->with([
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
