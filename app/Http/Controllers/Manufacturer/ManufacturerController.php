<?php

namespace App\Http\Controllers\Manufacturer;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCustomerRequest;
use App\Http\Requests\Manufacturer\CreateManufacturerRequest;
use App\Models\Manufacturer\Manufacturer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class ManufacturerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ( $request->ajax() ) {
            $manufacturers = Manufacturer::where("business_id", Auth::user()->tenant->id)->get();
            return DataTables::of($manufacturers)
                ->addColumn('medicine', function ($manufacturer){
                    return 0;
                })
                ->addColumn('action', function ($manufacturer){
                    $editUrl = route('manufacturers.edit', ['manufacturer' => $manufacturer->id] );
                    $destroyRoute = route('manufacturers.destroy', ['manufacturer' => $manufacturer->id] );
                    $csrf_token = csrf_token();
                    return "<a href=\"$editUrl\" class=\"action-icon\"> <i class=\"mdi mdi-square-edit-outline\"></i></a>
                            <form class=\"d-inline-block\" id=\"customer-delete-$manufacturer->id\" action=\"$destroyRoute\" method=\"post\">
                                <input type='hidden' name='_token' value='$csrf_token' >
                                <input type=\"hidden\" name=\"id\" value=\"$manufacturer->id\">
                                <a href=\"javascript:void(0);\" onclick=\"deleteConfirm($manufacturer->id)\" class=\"action-icon\"> <i class=\"mdi mdi-delete\"></i></a>
                            </form>";
                })
                ->rawColumns(['medicine', 'action'])
                ->make();
        }
        return view("ui.manufacturer.pages.PaginatedManufacturerList");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("ui.manufacturer.pages.CreateManufacturer");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateManufacturerRequest $request)
    {
        $data = $request->only("name", "phone", "email", "address");
        $data["business_id"] = Auth::user()->tenant->id;

        Manufacturer::create($data);

        return redirect()->route("manufacturers.index");
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
