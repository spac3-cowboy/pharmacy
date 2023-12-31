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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('business_id');
            $table->unsignedInteger("total_quantity");
            $table->unsignedDouble("sub_total");
            $table->unsignedDouble("grand_total");
            $table->unsignedDouble("flat_discount")->default(0);
            $table->unsignedDouble("vat_amount")->default(0);
            $table->unsignedDouble("paid");
            $table->enum("status", ["delivered", "partially returned", "full returned"])->default("delivered");
            $table->unsignedDouble("due")->default(0);
            $table->unsignedBigInteger("customer_id")->nullable();
	
	        $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('business_id');
            $table->unsignedBigInteger("sale_id");
            $table->unsignedInteger("quantity");
            $table->unsignedInteger("discount")->default(0); // in %
            $table->unsignedBigInteger("stock_id");
            $table->unsignedDouble("total");

            $table->timestamps();
	
	
	        $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
