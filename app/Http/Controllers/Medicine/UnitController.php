<?php

namespace App\Http\Controllers\Medicine;

use App\Http\Controllers\Controller;
use App\Models\Medicine\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ( $request->ajax() ) {
            $units = Unit::where("business_id", Auth::user()->owned_tenant->id)->get();
            return DataTables::of($units)
	            ->addColumn("medicines", function ($unit){
					return $unit->medicines->count();
	            })
                ->addColumn('action', function ($unit) {
                    $editUrl = route('units.edit', ['unit' => $unit->id] );
                    $destroyRoute = route('units.destroy', ['unit' => $unit->id] );
                    $csrf_token = csrf_token();
					if( $unit->medicines->count() < 1 ) {
						return "<a href=\"$editUrl\" class=\"action-icon\"> <i class=\"mdi mdi-square-edit-outline\"></i></a>
	                            <form class=\"d-inline-block\" id=\"unit-delete-$unit->id\" action=\"$destroyRoute\" method=\"post\">
	                                <input type='hidden' name='_token' value='$csrf_token' >
	                                <input type=\"hidden\" name=\"id\" value=\"$unit->id\">
	                                <a href=\"javascript:void(0);\" onclick=\"deleteConfirm($unit->id)\" class=\"action-icon\"> <i class=\"mdi mdi-delete\"></i></a>
	                            </form>";
					} else {
						return "<a href=\"$editUrl\" class=\"action-icon\"> <i class=\"mdi mdi-square-edit-outline\"></i></a>";
					}
                })
                ->make();
        }
        return view("ui.unit.pages.PaginatedUnitList");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("ui.unit.pages.CreateUnit");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
	    try
	    {
	        Unit::create([
	            "name" => $request->get("name"),
	            "business_id" => Auth::user()->owned_tenant->id
	        ]);
	    }
		catch (\Exception $exception)
		{
		
		    return redirect()->back()->withErrors(["msg" => $exception->getMessage()]);
	    }

        return redirect()->route("units.index");
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
		$unit = Unit::find($id);
	    return view("ui.unit.pages.EditUnit", [
			"unit" => $unit
	    ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
			"name" => "required|string"
        ]);
		
		$unit = Unit::find($id);
		if ( $unit ) {
			$unit->update([
				"name" => $request->name
			]);
			
			return redirect()->route("units.index");
		}
	    return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
