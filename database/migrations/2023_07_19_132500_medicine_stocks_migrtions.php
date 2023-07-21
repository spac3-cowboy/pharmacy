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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("quantity"); // quantity = available amount of medicines
            $table->unsignedBigInteger("medicine_id");
            $table->unsignedBigInteger("manufacturer_id");
            $table->date("manufacturing_date");
            $table->date("expiry_date");
            $table->string("batch");
            $table->unsignedDouble("buy_price");
            $table->unsignedDouble("mrp");
            $table->unsignedDouble("cost");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
