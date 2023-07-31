<?php

namespace App\Models\Tenant;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class, "id", "business_id");
    }

    public function owner()
    {
        return $this->belongsTo(User::class, "user_id");
    }
}
