<?php

namespace App\Models\Return;

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
}
