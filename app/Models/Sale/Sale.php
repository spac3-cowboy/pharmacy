<?php

namespace App\Models\Sale;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];


    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function customer()
    {
        return  $this->belongsTo(User::class, "customer_id");
    }


}
