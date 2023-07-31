<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('business_id');
            $table->unsignedBigInteger('vendor_id');
            $table->date("purchase_date");
            $table->unsignedDouble("amount");
            $table->unsignedDouble("paid");
            $table->timestamps();

            $table->softDeletes();
        });
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('business_id');
            $table->unsignedDouble("purchase_id");
            $table->string("batch", 500);
            $table->unsignedBigInteger("medicine_id");
            $table->unsignedInteger("quantity");
            $table->date("manufacturing_date");
            $table->date("expiry_date");
            $table->unsignedDouble("mrp");
            $table->unsignedDouble("buy_price");
            $table->unsignedDouble("flat_discount");
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
        Schema::dropIfExists('purchase_items');
    }
};
