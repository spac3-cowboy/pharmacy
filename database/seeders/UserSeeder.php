<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // seeding admin
        User::create([
            "name" => "Super Admin",
            "email" => "admin@admin.com",
            "business_id" => "1",
            "phone" => "01923093029",
            "user_type" => "1",
            "password" => Hash::make("12345")
        ]);
        // seeding Employee
        User::create([
            "name" => "Mr. Admin",
            "email" => "employee@employee.com",
            "phone" => "01723093029",
            "business_id" => "1",
            "user_type" => "2",
            "password" => Hash::make("12345")
        ]);
        // seeding doctor
        User::create([
            "name" => "Mr. Doctor",
            "email" => "doctor@doctor.com",
            "phone" => "01823093029",
            "business_id" => "1",
            "user_type" => "3",
            "password" => Hash::make("12345")
        ]);
        // seeding customer
        User::create([
            "name" => "Mr. Customer",
            "email" => "customer@customer.com",
            "phone" => "01123093029",
            "business_id" => "1",
            "user_type" => "4",
            "password" => Hash::make("12345")
        ]);
    }
}
