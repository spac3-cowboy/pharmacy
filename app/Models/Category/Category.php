<?php

namespace App\Models\Category;

use App\Models\Medicine\Medicine;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }
}
