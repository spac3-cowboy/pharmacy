<?php

namespace App\Models\Medicine;

use App\Models\Cart\Cart;
use App\Models\Manufacturer\Manufacturer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Stock extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];


    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public static function inStockProducts(string $key = null, int $cat_id = null, int $vendor_id = null)
    {

        $stocks = [];
        Stock::with(["medicine.category"])
                ->whereDate("expiry_date", ">", Carbon::today()->toDateString())
                ->where("quantity", ">",     0)
                ->where("business_id", Auth::user()->owned_tenant->id)
                ->whereHas("medicine", function($query) use($key, $cat_id, $vendor_id) {
                    if ( $key ) {
                        $query->where("name", "like", "%$key%");
                    }
                    if ( $cat_id ) {
                        $query->where("category_id", $cat_id);
                    }
                })
                ->get()
                ->unique("medicine_id")
                ->each(function ($stock) use(&$stocks) {
                    $stocks[] = $stock;
                });
        return collect($stocks);
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
        return $this->belongsTo(Manufacturer::class, "manufacturer_id");
    }
}
