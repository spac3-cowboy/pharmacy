<?php

namespace Database\Factories\Medicine;

use App\Models\Category\Category;
use App\Models\Manufacturer\Manufacturer;
use App\Models\Medicine\Medicine;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class StockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "quantity"  => $this->faker->numberBetween(1,100),
            "medicine_id" => Medicine::select("id")->get()->pluck("id")->random(),
            "manufacturer_id" => Manufacturer::select("id")->get()->pluck("id")->random(),
            "manufacturing_date" => Carbon::today()->subDays(rand(100,1000)),
            "expiry_date" => Carbon::today()->addDays(rand(100,1000)),
            "batch" => $this->faker->uuid,
            "buy_price" => $this->faker->numberBetween(1,100),
            "mrp" => $this->faker->numberBetween(10,1000),
            "cost" => 0
        ];
    }
}
