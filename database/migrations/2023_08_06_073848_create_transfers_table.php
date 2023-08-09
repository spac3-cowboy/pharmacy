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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
	        $table->unsignedBigInteger('business_id');
	        $table->unsignedInteger("total_quantity");
	        $table->unsignedDouble("sub_total");
	        $table->unsignedDouble("grand_total");
	        $table->unsignedDouble("flat_discount")->default(0);
	        $table->unsignedDouble("vat_amount")->default(0);
	        $table->unsignedDouble("paid");
	        $table->unsignedDouble("due")->default(0);
	        $table->text("note")->nullable();
	        $table->unsignedBigInteger("customer_id")->nullable();
	        $table->string("batch", 500);
	        $table->unsignedBigInteger("stock_id");
			
            $table->timestamps();
			
			$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
