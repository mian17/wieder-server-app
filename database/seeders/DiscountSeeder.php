<?php

namespace Database\Seeders;

use App\Models\Discount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $iterationCount = 5;
        for ($i = 0; $i < $iterationCount; $i++) {
            Discount::create([
                'name' => strtoupper(fake()->word() . fake()->randomNumber(2, true)),
                'desc' => fake()->sentence(),
                'total_money_condition' => fake()->randomNumber(6, true),
                'discount_percent' => fake()->numberBetween(10, 80),
                'expiration_date' => Carbon::now()->addDays(random_int(1, 100)),
            ]);
        }
        for ($i = 0; $i < 3; $i++) {
            Discount::create([
                'name' => strtoupper(fake()->word() . fake()->randomNumber(2, true)),
                'desc' => fake()->sentence(),
                'total_money_condition' => fake()->randomNumber(6, true),
                'discount_percent' => fake()->numberBetween(10, 80),
                'expiration_date' => Carbon::now()->subDays(random_int(1, 100)),
            ]);
        }

    }
}
