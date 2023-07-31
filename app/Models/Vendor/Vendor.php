<?php

namespace App\Models\Vendor;

use App\Models\Purchase\Purchase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];


    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
