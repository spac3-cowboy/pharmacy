<?php

namespace App\Models\Medicine;

use App\Models\Category\Category;
use App\Models\Manufacturer\Manufacturer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medicine extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
	protected $appends = ["image"];
	
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
	
	public function unit()
	{
		return $this->belongsTo(Unit::class);
	}
	
	
	public function getImageAttribute()
	{
		return $this->category->image;
	}
}
