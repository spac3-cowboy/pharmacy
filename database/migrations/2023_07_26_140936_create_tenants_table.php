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
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("image")->default("default_tenant.jpg");
            $table->string("address");
            $table->string("email");
            $table->string("phone");
            $table->unsignedBigInteger("user_id");

            $table->foreign("user_id")
                    ->references("id")
                    ->on("users");

            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tetants');
    }
};
