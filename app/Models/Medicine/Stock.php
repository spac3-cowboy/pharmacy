<?php

namespace App\Models\Medicine;

use App\Models\Manufacturer\Manufacturer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function inStockProducts(): \Illuminate\Support\Collection
    {
        return Stock::whereDate("expiry_date", ">", Carbon::today()->toDateString())
                    ->where("quantity", ">",     0)
                    ->get();
    }

    public static function outOfStock(): \Illuminate\Support\Collection
    {
        return Stock::whereDate("expiry_date", ">", Carbon::today()->toDateString())
                    ->where("quantity", "<", 1)
                    ->get();
    }

    public static function emergencyStock(): \Illuminate\Support\Collection
    {
        return Stock::whereDate("expiry_date", ">", Carbon::today()->toDateString())
                ->where("quantity", "<", 1)
                ->get();
    }

    public static function expiredStock(): \Illuminate\Support\Collection
    {
        return Stock::whereDate("expiry_date", "<", Carbon::today()->toDateString())
                    ->get();
    }

    public static function toBeExpired(): \Illuminate\Support\Collection
    {
        return Stock::whereDate("expiry_date", "<", Carbon::today()->subDays(7))
                    ->get();
    }


    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
    public function manufacturer()
    {
        return $this->belongsTo( Manufacturer::class);
    }
}
