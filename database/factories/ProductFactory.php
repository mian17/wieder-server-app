<?php

namespace Database\Factories;

use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProductFactory extends Factory
{
    /**
     * @throws Exception
     */
    public function definition(): array
    {
//        $warehouse_groups = ['1_2', '2_3', '3_4', '1_5', '1_3', '1_4', '1_2_3', '2_3_4', '3_4_5', '1_2_3_4_5'];
        $unit = ['Cái', 'Thùng', 'Bộ'];
        $status = ["Hiển thị", "Ẩn"];
        return [
            'category_id' => fake()->numberBetween(1, 19),
//            'warehouse_id_group' => $warehouse_groups[rand(0, 9)],
            'name' => fake()->unique()->userName(),
            'summary' => fake()->text(),
            'desc' => fake()->paragraph(),
            'detail_info' => fake()->paragraph(),
//            'quantity' => fake()->numberBetween(1, 5000),
            'brand' => fake()->company(),
            'SKU' => fake()->isbn10(),
            'mass' => fake()->randomNumber(1, 5000),
            'cost_price' => fake()->randomNumber(1, 5000000),
            'price' => fake()->randomNumber(1, 5000000),
            'unit' => $unit[random_int(0, 2)],
            'status' => $status[random_int(0, 1)],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
