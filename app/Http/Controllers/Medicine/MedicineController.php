<?php

namespace App\Http\Controllers\Medicine;

use App\Http\Controllers\Controller;
use App\Http\Requests\Medicine\CreateMedicineRequest;
use App\Http\Requests\Medicine\UpdateMedicineRequest;
use App\Models\Category\Category;
use App\Models\Manufacturer\Manufacturer;
use App\Models\Medicine\Medicine;
use App\Models\Medicine\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class MedicineController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request)
	{

		if ($request->ajax())
		{
			$medicines = Medicine::where("business_id", Auth::user()->owned_tenant->id)->get();
			return DataTables::of($medicines)
				->addColumn('image', function ($medicine) {
					return "<img src='/category/$medicine->image' width='80px' height='80px' />";
				})
				->addColumn('category', function ($medicine) {
					return $medicine->category->name;
				})
				->addColumn('action', function ($medicine) {
					$viewUrl = route('medicines.show', ['medicine' => $medicine->id]);
					$editUrl = route('medicines.edit', ['medicine' => $medicine->id]);
					$destroyRoute = route('medicines.destroy', ['medicine' => $medicine->id]);
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
		return view("ui.medicine.pages.PaginatedMedicineList");
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		$categories = Category::where("business_id", Auth::user()->owned_tenant->id)->get();
		$manufacturers = Manufacturer::where("business_id", Auth::user()->owned_tenant->id)->get();
		$units = Unit::where("business_id", Auth::user()->owned_tenant->id)->get();
		$medicines = Medicine::where("business_id", Auth::user()->owned_tenant->id)
								->orWhere("globally_visible", true)
								->get();

		return view("ui.medicine.pages.CreateMedicine", [
			"categories" => $categories,
			"manufacturers" => $manufacturers,
			"units" => $units,
			"medicines" => $medicines
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(CreateMedicineRequest $request)
	{

		try
		{
			$data = $request->except(["_token", "batch"]);
			$data["business_id"] = Auth::user()->owned_tenant->id;
			// checking if medicine already exists in the db
			$exists = Medicine::where([
				"business_id" => $data["business_id"],
				"name" => $request->name
			])->first();
			if ( $exists )
			{
				return redirect()->back()->withErrors(["msg" => "Medicine Name Already Taken" ]);
			}
			Medicine::create($data);
		}
		catch (\Exception $exception)
		{
			return redirect()->back()->withErrors(["msg" => $exception->getMessage()]);
		}

		return redirect()->route("medicines.index")->with(["msg" => "Medicine Created Successfully"]);
	}

	/**
	 * Display the specified resource.
	 */
	public function show(string $id)
	{
		if (\request()->ajax())
		{
			$medicine = Medicine::with(["stocks"])
				->where("id", $id)
				->first();
			return ["medicine" => $medicine];
		}
		$medicine = Medicine::find($id);
		return view("ui.medicine.pages.ShowMedicine", [
			"medicine" => $medicine
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(string $id)
	{
		$medicine = Medicine::find($id);
		$categories = Category::where("business_id", Auth::user()->owned_tenant->id)->get();
		$manufacturers = Manufacturer::where("business_id", Auth::user()->owned_tenant->id)->get();
		$units = Unit::where("business_id", Auth::user()->owned_tenant->id)->get();
		return view("ui.medicine.pages.EditMedicine", [
			"medicine" => $medicine,
			"categories" => $categories,
			"manufacturers" => $manufacturers,
			"units" => $units
		]);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(UpdateMedicineRequest $request, string $id)
	{
		$medicine = Medicine::find($id);
		$data = $request->only(["name", "generic_name", "shelf", "price", "manufacturing_price", "strength", "category_id", "manufacturer_id", "unit_id"]);

		$medicine->update($data);

		return redirect()->route("medicines.index");
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $id)
	{
		//
	}
}
