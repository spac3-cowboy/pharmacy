<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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

	public function profile()
	{
		return view("ui.profile.pages.Profile");
	}

    public function loginPage()
    {
		Auth::logout();
        return view("Auth.Login");
    }
    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required|string"
        ]);
		$rem = $request->get("remember_me") == "on";
        if ( Auth::attempt($request->only(["email", "password"]), $rem) )
		{
			if ( Auth::user()->user_type == 1 )
			{
                return redirect()->route("admin.dashboard");
			}
			if ( Auth::user()->user_type == 2 )
			{
                return redirect()->route("dashboard");
			}
        }

        return redirect()->back()->withErrors(["msg" => "Wrong Credentials"]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->back();
    }
}
