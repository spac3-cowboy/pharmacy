<?php

namespace App\Models\Return;

use App\Models\Medicine\Stock;
use App\Models\Sale\SaleItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MReturnItem extends Model
{
    use HasFactory;
	protected $table = "return_items";
	protected $guarded = [];
	
	
	public function return()
	{
		return $this->belongsTo(MReturn::class);
	}
	
	public function sale_item()
	{
		return $this->belongsTo(SaleItem::class, "sale_item_id");
	}
	public function stock()
	{
		return $this->belongsTo(Stock::class, "stock_id");
	}
	
}
