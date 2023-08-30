<?php

namespace App\Http\Controllers\Admin\Medicine;

use App\Http\Controllers\Controller;
use App\Models\Category\Category;
use App\Models\GlobalMedicine;
use App\Models\Manufacturer\Manufacturer;
use App\Models\Medicine\Medicine;
use App\Models\Medicine\Unit;
use App\Models\Tenant\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
		$result = DB::transaction(function () use($request) {
			$gm = GlobalMedicine::create([
				"name" => $request->name,
				"generic_name" => $request->generic_name,
				"shelf" => $request->shelf ?? null,
				"price" => $request->price,
				"manufacturing_price" => $request->manufacturing_price,
				"strength" => $request->strength,
				"category_id" => $request->category_id,
				"unit_id" => $request->unit_id,
				"globally_visible" => $request->globally_visible
			]);
			if( $request->globally_visible )
			{
				Tenant::all()
					->each(function ($tenant) use($request, $gm) {
						Medicine::create([
							"name" => $request->name,
							"generic_name" => $request->generic_name,
							"shelf" => $request->shelf ?? null,
							"price" => $request->price,
							"manufacturing_price" => $request->manufacturing_price,
							"strength" => $request->strength,
							"category_id" => $request->category_id,
							"unit_id" => $request->unit_id,
							"global_medicine_id" => $gm->id,
							"business_id" => $tenant->id
						]);
					});
			}

			return true;
		});

		return back()->with("Medicine Created");
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
