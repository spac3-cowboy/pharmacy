<?php

namespace App\Models\Sale;

use App\Models\Medicine\Stock;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleItem extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "sale_items";
    protected $guarded = [];


    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }
    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }
}
