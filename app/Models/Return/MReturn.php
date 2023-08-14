<?php

namespace App\Models\Return;

use App\Models\Medicine\Stock;
use App\Models\Sale\Sale;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MReturn extends Model
{
    use HasFactory;
	protected $table = "returns";
	protected $guarded = [];
	
	
	public function items()
	{
		return $this->hasMany(MReturnItem::class, "return_id");
	}
	
	
	public function sale()
	{
		return $this->belongsTo(Sale::class);
	}
}
