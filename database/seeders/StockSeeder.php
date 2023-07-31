<?php

namespace Database\Seeders;

use App\Models\Medicine\Stock;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Stock::factory(50)->create();
        Stock::all()->each(function ($stock) {
            $stock->update([
                "cost" => $stock->quantity * $stock->buy_price
            ]);
            $stock->save();
        });
    }
}
