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
        Schema::create('global_medicines', function (Blueprint $table) {
	        $table->id();
	        $table->string("name")->unique();
	        $table->string("generic_name");
	        $table->string("shelf");
	        $table->double("price");
	        $table->double("manufacturing_price");
	        $table->string("strength");
	        $table->string("image")->default("default_medicine_avatar.png");
	        $table->boolean("globally_visible")->default(false);
	        $table->unsignedBigInteger("category_id");
	        $table->unsignedBigInteger("unit_id");

	        $table->foreign("category_id")
		          ->references("id")
		          ->on("categories");


	        $table->foreign("unit_id")
		          ->references("id")
		          ->on("units");

	        $table->softDeletes();
	        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('global_medicines');
    }
};
