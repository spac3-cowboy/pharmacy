<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // seeding admin
        User::create([
            "name" => "Mr. Admin",
            "email" => "admin@admin.com",
            "user_type" => "1",
            "password" => Hash::make("12345")
        ]);
        // seeding Employee
        User::create([
            "name" => "Mr. Admin",
            "email" => "employee@employee.com",
            "user_type" => "2",
            "password" => Hash::make("12345")
        ]);
        // seeding doctor
        User::create([
            "name" => "Mr. Doctor",
            "email" => "doctor@doctor.com",
            "user_type" => "3",
            "password" => Hash::make("12345")
        ]);
        // seeding customer
        User::create([
            "name" => "Mr. Customer",
            "email" => "customer@customer.com",
            "user_type" => "4",
            "password" => Hash::make("12345")
        ]);
    }
}
