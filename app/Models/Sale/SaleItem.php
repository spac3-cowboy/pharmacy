<?php

namespace App\Models\Sale;

use App\Models\Medicine\Stock;
use App\Models\Return\MReturnItem;
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
	
	public function return_items()
	{
		return $this->hasMany(MReturnItem::class, "sale_item_id");
	}
	
	public function getReturnedQuantityAttribute()
	{
		return $this->return_items
					->reduce(function ($total, $ri) {
						return $ri->quantity + $total;
					}, 0);
	}
	public function getReturnableQuantityAttribute()
	{
		return $this->quantity - $this->returned_quantity;
	}
}
