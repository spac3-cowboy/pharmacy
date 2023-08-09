<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Setting extends Model
{
    use HasFactory;
    protected $guarded = [];


    public static function key(string $key)
    {
        $s = Setting::where("key", $key)
	            ->where("business_id", Auth::user()->owned_tenant->id)
	            ->first()->value ?? "";
		
		return $s;
    }
}
