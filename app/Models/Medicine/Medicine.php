<?php

namespace App\Models\Medicine;

use App\Models\Category\Category;
use App\Models\Manufacturer\Manufacturer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }

}
