<?php

namespace Database\Seeders;

use App\Models\Medicine\Unit;
use App\Models\Tenant\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Unit::create([
			"name" => "Unit 1",
			"business_id" => 1
		]);
        Unit::create([
			"name" => "Unit 2",
			"business_id" => 1
		]);
        Unit::create([
			"name" => "Unit 3",
			"business_id" => 1
		]);
    }
}
