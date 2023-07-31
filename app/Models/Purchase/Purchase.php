<?php

namespace App\Models\Purchase;

use App\Models\Medicine\Medicine;
use App\Models\Vendor\Vendor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];


    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }


    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
