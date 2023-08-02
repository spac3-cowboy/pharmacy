<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category\Category;
use App\Models\Medicine\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ( $request->ajax() ) {
            $categories = Category::where("business_id", Auth::user()->owned_tenant->id)->get();
            return DataTables::of($categories)
                ->addColumn('medicine', function ($category){
                    return $category->medicines->count();
                })
                ->addColumn('action', function ($category){
                    $editUrl = route('categories.edit', ['category' => $category->id] );
                    $destroyRoute = route('categories.destroy', ['category' => $category->id] );
                    $csrf_token = csrf_token();
                    return "<a href=\"$editUrl\" class=\"action-icon\"> <i class=\"mdi mdi-square-edit-outline\"></i></a>
                            <form class=\"d-inline-block\" id=\"customer-delete-$category->id\" action=\"$destroyRoute\" method=\"post\">
                                <input type='hidden' name='_token' value='$csrf_token' >
                                <input type=\"hidden\" name=\"id\" value=\"$category->id\">
                                <a href=\"javascript:void(0);\" onclick=\"deleteConfirm($category->id)\" class=\"action-icon\"> <i class=\"mdi mdi-delete\"></i></a>
                            </form>";
                })
                ->rawColumns(['medicine', 'action'])
                ->make();
        }
        return view("ui.category.pages.PaginatedCategoryList");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("ui.category.pages.CreateCategory");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string"
        ]);
        Category::create([
            "name" => $request->name,
            "business_id" => Auth::user()->owned_tenant->id
        ]);
        return redirect()->route("categories.index")->with(["msg" => "Category Created Successfully"]);
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
		
        return view("ui.category.pages.EditCategory", [ "category" => Category::find($id) ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([ "name" => "required|string" ]);
		
		$category = Category::find($id);
		if ( $category ) {
			$category->update([
				"name" => $request->name
			]);
			
			return redirect()->route("categories.index")->with(["msg" => "success"]);
		}
		return back()->withErrors(["msg" => "success"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
