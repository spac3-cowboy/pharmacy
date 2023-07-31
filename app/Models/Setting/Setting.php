<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $guarded = [];


    public static function key(string $key)
    {
        return Setting::where("key", $key)->first()->value ?? "";
    }
}
