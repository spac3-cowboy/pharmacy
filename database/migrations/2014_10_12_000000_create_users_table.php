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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('business_id')->nullable();
            $table->string('name');
            $table->string('image')->default("default_avatar.png");
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique();
            $table->string('address', 500)->nullable();
            $table->string('bg')->nullable(); // bg = blood group
            $table->unsignedInteger('age')->nullable();
            $table->enum('user_type', [1,2,3,4])->default(2); // 1=super admin, 2=admin, 3=Doctor, 4=customer
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');


            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
