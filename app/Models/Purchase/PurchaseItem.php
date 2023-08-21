<?php

namespace App\Models\Purchase;

use App\Models\ForPharmacy\Manufacturer;
use App\Models\Medicine\Medicine;
use App\Models\Vendor\Vendor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseItem extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $table = "purchase_items";


    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }


	public function vendor()
	{
		return $this->belongsTo(Vendor::class);
	}
	public function manufacturer()
	{
		return $this->belongsTo(Manufacturer::class);
	}
}
