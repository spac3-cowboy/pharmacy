<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = Setting::where("business_id", Auth::user()->tenant->id)->get();
        return view("ui.settings.pages.Settings", [
            "settings" => $settings
        ]);
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
    public function update(Request $request)
    {
        $request->validate([
            "key" => "required",
            "value" => "required"
        ]);
        $s = Setting::where("key", $request->key)->first();
        if ( $s ) {
            $s->update([
                "value" => $request->value
            ]);
        } else {
            Setting::create([
                "key" => $request->key,
                "value" => $request->value,
                "business_id" => Auth::user()->owned_tenant->id
            ]);
        }


        return [ "msg" => "success" ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
