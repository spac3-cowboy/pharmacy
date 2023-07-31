<?php

namespace Database\Seeders;

use App\Models\Tenant\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tenant::create([
            "name" => "Innova Pharmecy",
            "address" =>  "",
            "email" => "innovapharmacy@innovainfosys.com",
            "phone" => "01290139128",
            "user_id" => 1
        ]);
    }
}
