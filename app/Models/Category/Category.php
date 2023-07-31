<?php

namespace App\Models\Category;

use App\Models\Medicine\Medicine;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }
}
