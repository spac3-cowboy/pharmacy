<?php

namespace Database\Factories\Medicine;

use App\Models\Category\Category;
use App\Models\Manufacturer\Manufacturer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MedicineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => $this->faker->name,
            "generic_name" => $this->faker->name,
            "shelf" => $this->faker->postcode,
            "price" => $this->faker->numberBetween(10,1000),
            "manufacturing_price" => $this->faker->numberBetween(1,100),
            "strength" => $this->faker->userName,
            "image" => "",
            "batch" => $this->faker->uuid,
            "category_id" => Category::select("id")->get()->pluck("id")->random(),
            "manufacturer_id" => Manufacturer::select("id")->get()->pluck("id")->random()
        ];
    }
}
