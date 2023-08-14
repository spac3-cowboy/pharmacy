<?php

namespace App\Http\Controllers\Admin\Medicine;

use App\Http\Controllers\Controller;
use App\Models\Category\Category;
use App\Models\Manufacturer\Manufacturer;
use App\Models\Medicine\Medicine;
use App\Models\Medicine\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
	
	    if ( $request->ajax() )
	    {
		    $medicines = Medicine::all();
		    return DataTables::of($medicines)
			    ->addColumn('image', function ($medicine){
				    return "<img src='/category/$medicine->image' width='80px' height='80px' />";
			    })
			    ->addColumn('category', function ($medicine){
				    return $medicine->category->name;
			    })
			    ->addColumn('action', function ($medicine){
				    $viewUrl = route('medicines.show', ['medicine' => $medicine->id] );
				    $editUrl = route('medicines.edit', ['medicine' => $medicine->id] );
				    $destroyRoute = route('medicines.destroy', ['medicine' => $medicine->id] );
				    $csrf_token = csrf_token();
				    return "<a href=\"$viewUrl\" class=\"action-icon\"><i class=\"ri-eye-fill\"></i></a>
							<a href=\"$editUrl\" class=\"action-icon\"> <i class=\"mdi mdi-square-edit-outline\"></i></a>
                            <form class=\"d-inline-block\" id=\"medicine-delete-$medicine->id\" action=\"$destroyRoute\" method=\"post\">
                                <input type='hidden' name='_token' value='$csrf_token' >
                                <input type=\"hidden\" name=\"id\" value=\"$medicine->id\">
                            </form>";
			    })
			    ->rawColumns(['image', 'category', 'manufacturer', 'action'])
			    ->make();
	    }
	    return view("ui.admin.medicine.pages.PaginatedMedicineList");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
	    $categories = Category::all();
	    $manufacturers = Manufacturer::all();
	    $units = Unit::all();
	    $medicines = Medicine::all();
	    return view("ui.admin.medicine.pages.CreateMedicine", [
		    "categories" => $categories,
		    "manufacturers" => $manufacturers,
		    "units" => $units,
		    "medicines" => $medicines
	    ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
		
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
