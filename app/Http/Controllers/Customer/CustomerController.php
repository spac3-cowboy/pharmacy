<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCustomerRequest;
use App\Http\Requests\Customer\EditCustomerRequest;
use App\Models\Sale\Sale;
use App\Models\Setting\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ( $request->ajax() ) {
            $customers = User::customers();
            return DataTables::of($customers)
                ->addColumn('due', function ($user){
                    return 0;
                })
                ->addColumn('action', function ($user){
	                $viewUrl = route('customers.show', ['customer' => $user->id] );
                    $editUrl = route('customers.edit', ['customer' => $user->id] );
                    $destroyRoute = route('customers.destroy', ['customer' => $user->id] );
                    $csrf_token = csrf_token();
                    return "
							<a href=\"$viewUrl\" class=\"action-icon\"><i class=\"ri-eye-fill\"></i></a>
							<a href=\"$editUrl\" class=\"action-icon\"> <i class=\"mdi mdi-square-edit-outline\"></i></a>
                            <form class=\"d-inline-block\" id=\"customer-delete-$user->id\" action=\"$destroyRoute\" method=\"post\">
                                <input type='hidden' name='_token' value='$csrf_token' >
                                <input type=\"hidden\" name=\"id\" value=\"$user->id\">
                                <a href=\"javascript:void(0);\" onclick=\"deleteConfirm($user->id)\" class=\"action-icon\"> <i class=\"mdi mdi-delete\"></i></a>
                            </form>";
                })
                ->make();
        }
        return view("ui.customer.pages.PaginatedCustomerList");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("ui.customer.pages.CreateCustomer");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCustomerRequest $request)
    {
        $data = $request->only(["name", "email", "phone"]);
        $data["password"] = Hash::make("12345678");
        if ( $request->exists("bg") )
        {
            $data["bg"] = $request->bg;

        }
        $data["user_type"] = 4;
        $data["business_id"] = Auth::user()->owned_tenant->id;
//        dd($data);

        $user = User::create($data);

        if ( $user ) {
            return redirect()->route("customers.index")->with(["msg" => "New User Created"]);
        }

        return redirect()->back()->withErrors(["msg" => "Failed! User Not Created"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
		$currency_symbol = Setting::key("currency_symbol");
	    $customer = User::find($id);
	    $total_bought = Sale::where("customer_id", $customer->id)
		                ->get()
	                    ->reduce(function($total, $sale){
							return $sale->grand_total + $total;
	                    });
	    $total_paid = Sale::where("customer_id", $customer->id)
		                ->get()
	                    ->reduce(function($total, $sale){
							return $sale->paid + $total;
	                    });
	    $total_due = $total_bought - $total_paid;
		
	    return view("ui.customer.pages.ShowCustomer", [
			"customer" => $customer,
			"total_bought" => $total_bought . $currency_symbol,
		    "total_paid" => $total_paid . $currency_symbol,
		    "total_due" => $total_due . $currency_symbol
	    ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
	    $customer = User::find($id);
	    return view("ui.customer.pages.EditCustomer", [
		    "customer" => $customer
	    ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditCustomerRequest $request, string $id)
    {
        $data = $request->only(["name", "age", "email", "phone", "address", "bg"]);
		$user = User::find($id);
		if ( $user ) {
			$user->update($data);
		}
		
		return redirect()->route("customers.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
