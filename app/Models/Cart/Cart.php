<?php

namespace App\Models\Cart;

use App\Models\Medicine\Medicine;
use App\Models\Medicine\Stock;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];


    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

}
