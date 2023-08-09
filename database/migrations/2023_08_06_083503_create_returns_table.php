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
        Schema::create('returns', function (Blueprint $table) {
            $table->id();
	        $table->unsignedBigInteger("business_id");
	        $table->unsignedBigInteger("sale_id");
	        $table->unsignedDouble("total");
	        $table->string("note", 500);
			
            $table->timestamps();
	
	        $table->softDeletes();
        });
        Schema::create('return_items', function (Blueprint $table) {
            $table->id();
	        $table->unsignedBigInteger('business_id');
	        $table->unsignedBigInteger("return_id");
	        $table->unsignedBigInteger("sale_item_id");
	        $table->unsignedInteger("quantity");
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
        Schema::dropIfExists('returns');
    }
};
