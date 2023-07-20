<?php

namespace App\Http\Controllers\Medicine;

use App\Http\Controllers\Controller;
use App\Http\Requests\Medicine\CreateMedicineRequest;
use App\Models\Category\Category;
use App\Models\Manufacturer\Manufacturer;
use App\Models\Medicine\Medicine;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ( $request->ajax() ) {
            $medicines = Medicine::all();
            return DataTables::of($medicines)
                ->addColumn('category', function ($medicine){
                    return $medicine->category->name;
                })
                ->addColumn('manufacturer', function ($medicine){
                    return $medicine->manufacturer->name;
                })
                ->addColumn('action', function ($medicine){
                    $editUrl = route('medicines.edit', ['medicine' => $medicine->id] );
                    $destroyRoute = route('medicines.destroy', ['medicine' => $medicine->id] );
                    $csrf_token = csrf_token();
                    return "<a href=\"$editUrl\" class=\"action-icon\"> <i class=\"mdi mdi-square-edit-outline\"></i></a>
                            <form class=\"d-inline-block\" id=\"medicine-delete-$medicine->id\" action=\"$destroyRoute\" method=\"post\">
                                <input type='hidden' name='_token' value='$csrf_token' >
                                <input type=\"hidden\" name=\"id\" value=\"$medicine->id\">
                                <a href=\"javascript:void(0);\" onclick=\"deleteConfirm($medicine->id)\" class=\"action-icon\"> <i class=\"mdi mdi-delete\"></i></a>
                            </form>";
                })
                ->rawColumns(['category', 'manufacturer', 'action'])
                ->make();
        }
        return view("ui.medicine.pages.PaginatedMedicineList");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $manufacturers = Manufacturer::all();
        return view("ui.medicine.pages.CreateMedicine", [
            "categories" => $categories,
            "manufacturers" => $manufacturers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateMedicineRequest $request)
    {
        $data = $request->except("_token");
        Medicine::create($data);

        return redirect()->route("medicines.index")->with(["msg" => "Medicine Created Successfully"]);
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
