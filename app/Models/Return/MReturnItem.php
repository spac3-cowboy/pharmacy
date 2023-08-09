<?php

namespace App\Models\Return;

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
}
