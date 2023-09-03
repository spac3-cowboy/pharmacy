<?php

namespace Database\Seeders;

use App\Models\Category\Category;
use App\Models\Tenant\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
			"name" => "Cat A",
			"image" => "default_category_image.png",
			"business_id" => 1
		]);
        Category::create([
			"name" => "Cat B",
			"image" => "default_category_image.png",
			"business_id" => 1
		]);
        Category::create([
			"name" => "Cat C",
			"image" => "default_category_image.png",
			"business_id" => 1
		]);
        Category::create([
			"name" => "Cat D",
			"image" => "default_category_image.png",
			"business_id" => 1
		]);
    }
}
