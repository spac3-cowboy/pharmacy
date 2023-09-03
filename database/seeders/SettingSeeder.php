<?php

namespace Database\Seeders;

use App\Models\Setting\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
	        "business_id" => 1,
			"key" => "vat",
			"value" => "15"
        ]);
        Setting::create([
	        "business_id" => 1,
			"key" => "logo",
			"value" => "default_site_logo.png"
        ]);
    }
}
