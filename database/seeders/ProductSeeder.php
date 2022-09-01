<?php

namespace Database\Seeders;

use App\Models\Product;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run(): void
    {
//        $warehouse_groups = ['1_2', '2_3', '3_4', '1_5', '1_3', '1_4', '1_2_3', '2_3_4', '3_4_5', '1_2_3_4_5'];
//        $status = ["Hiển thị", "Ẩn"];

        Product::create([
            'name' => 'Dưa hấu',
            'category_id' => 18,
//            'warehouse_id_group' => $warehouse_groups[rand(0, 9)],
            'summary' => fake()->text(),
            'desc' => fake()->paragraph(),
            'detail_info' => fake()->paragraph(),
            'quantity' => fake()->numberBetween(1, 5000),
            'SKU' => fake()->isbn10(),
            'mass' => '1000',
            'cost_price' => 100000,
            'price' => 50000,
            'unit' => "g",
            'status' => "Hiển thị",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Product::create([
            'name' => 'Dâu tây',
            'category_id' => 19,
//            'warehouse_id_group' => $warehouse_groups[rand(0, 9)],
            'summary' => fake()->text(),
            'desc' => fake()->paragraph(),
            'detail_info' => fake()->paragraph(),
            'quantity' => fake()->numberBetween(1, 5000),
            'SKU' => fake()->isbn10(),
            'mass' => '100',
            'cost_price' => 140000,
            'price' => 120000,
            'unit' => "kg",
            'status' => "Hiển thị",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Product::create([
            'name' => 'Măng cụt',
            'category_id' => 18,
//            'warehouse_id_group' => $warehouse_groups[rand(0, 9)],
            'summary' => fake()->text(),
            'desc' => fake()->paragraph(),
            'detail_info' => fake()->paragraph(),
            'quantity' => fake()->numberBetween(1, 5000),
            'SKU' => fake()->isbn10(),
            'mass' => '100',
            'cost_price' => 80000,
            'price' => 60000,
            'unit' => "kg",
            'status' => "Hiển thị",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Product::create([
            'name' => 'Chanh nhập khẩu',
            'category_id' => 19,
//            'warehouse_id_group' => $warehouse_groups[rand(0, 9)],
            'summary' => fake()->text(),
            'desc' => fake()->paragraph(),
            'detail_info' => fake()->paragraph(),
            'quantity' => fake()->numberBetween(1, 5000),
            'SKU' => fake()->isbn10(),
            'mass' => '100',
            'cost_price' => 200000,
            'price' => 200000,
            'unit' => "kg",
            'status' => "Hiển thị",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Product::create([
            'name' => 'Thanh long',
            'category_id' => 18,
//            'warehouse_id_group' => $warehouse_groups[rand(0, 9)],
            'summary' => fake()->text(),
            'desc' => fake()->paragraph(),
            'detail_info' => fake()->paragraph(),
            'quantity' => fake()->numberBetween(1, 5000),
            'SKU' => fake()->isbn10(),
            'mass' => '100',
            'cost_price' => 30000,
            'price' => 20000,
            'unit' => "kg",
            'status' => "Hiển thị",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Product::create([
            'name' => 'Táo',
            'category_id' => 19,
//            'warehouse_id_group' => $warehouse_groups[rand(0, 9)],
            'summary' => fake()->text(),
            'desc' => fake()->paragraph(),
            'detail_info' => fake()->paragraph(),
            'quantity' => fake()->numberBetween(1, 5000),
            'SKU' => fake()->isbn10(),
            'mass' => '100',
            'cost_price' => 150000,
            'price' => 120000,
            'unit' => "kg",
            'status' => "Hiển thị",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);



        Product::create([
            'name' => 'Thịt bò',
            'category_id' => 21,
//            'warehouse_id_group' => $warehouse_groups[rand(0, 9)],
            'summary' => fake()->text(),
            'desc' => fake()->paragraph(),
            'detail_info' => fake()->paragraph(),
            'quantity' => fake()->numberBetween(1, 5000),
            'SKU' => fake()->isbn10(),
            'mass' => '100',
            'cost_price' => 96000,
            'price' => 57000,
            'unit' => "kg",
            'status' => "Hiển thị",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Product::create([
            'name' => 'Trứng gà',
            'category_id' => 25,
//            'warehouse_id_group' => $warehouse_groups[rand(0, 9)],
            'summary' => fake()->text(),
            'desc' => fake()->paragraph(),
            'detail_info' => fake()->paragraph(),
            'quantity' => fake()->numberBetween(1, 5000),
            'SKU' => fake()->isbn10(),
            'mass' => '100',
            'cost_price' => 20000,
            'price' => 20000,
            'unit' => "kg",
            'status' => "Hiển thị",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Product::create([
            'name' => 'Cá hồi',
            'category_id' => 26,
//            'warehouse_id_group' => $warehouse_groups[rand(0, 9)],
            'summary' => fake()->text(),
            'desc' => fake()->paragraph(),
            'detail_info' => fake()->paragraph(),
            'quantity' => fake()->numberBetween(1, 5000),
            'SKU' => fake()->isbn10(),
            'mass' => '100',
            'cost_price' => 240000,
            'price' => 180000,
            'unit' => "kg",
            'status' => "Hiển thị",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Product::create([
            'name' => 'Gạo 5kg',
            'category_id' => 28,
//            'warehouse_id_group' => $warehouse_groups[rand(0, 9)],
            'summary' => fake()->text(),
            'desc' => fake()->paragraph(),
            'detail_info' => fake()->paragraph(),
            'quantity' => fake()->numberBetween(1, 5000),
            'SKU' => fake()->isbn10(),
            'mass' => '5000',
            'cost_price' => 28000,
            'price' => 14000,
            'unit' => "kg",
            'status' => "Hiển thị",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Product::create([
            'name' => 'Dưa leo',
            'category_id' => 27,
//            'warehouse_id_group' => $warehouse_groups[rand(0, 9)],
            'summary' => fake()->text(),
            'desc' => fake()->paragraph(),
            'detail_info' => fake()->paragraph(),
            'quantity' => fake()->numberBetween(1, 5000),
            'SKU' => fake()->isbn10(),
            'mass' => '1000',
            'cost_price' => 18000,
            'price' => 14000,
            'unit' => "kg",
            'status' => "Hiển thị",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Product::create([
            'name' => 'Mì ý',
            'category_id' => 29,
//            'warehouse_id_group' => $warehouse_groups[rand(0, 9)],
            'summary' => fake()->text(),
            'desc' => fake()->paragraph(),
            'detail_info' => fake()->paragraph(),
            'quantity' => fake()->numberBetween(1, 5000),
            'SKU' => fake()->isbn10(),
            'mass' => '500',
            'cost_price' => 28000,
            'price' => 14000,
            'unit' => "Hộp",
            'status' => "Hiển thị",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Product::create([
            'name' => 'Trà matcha đóng chai',
            'category_id' => 30,
//            'warehouse_id_group' => $warehouse_groups[rand(0, 9)],
            'summary' => fake()->text(),
            'desc' => fake()->paragraph(),
            'detail_info' => fake()->paragraph(),
            'quantity' => fake()->numberBetween(1, 5000),
            'SKU' => fake()->isbn10(),
            'mass' => '500',
            'cost_price' => 48000,
            'price' => 30000,
            'unit' => "Chai",
            'status' => "Hiển thị",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Product::create([
            'name' => 'Cà phê dạng hạt Arabica',
            'category_id' => 31,
//            'warehouse_id_group' => $warehouse_groups[rand(0, 9)],
            'summary' => fake()->text(),
            'desc' => fake()->paragraph(),
            'detail_info' => fake()->paragraph(),
            'quantity' => fake()->numberBetween(1, 5000),
            'SKU' => fake()->isbn10(),
            'mass' => '1000',
            'cost_price' => 48000,
            'price' => 30000,
            'unit' => "kg",
            'status' => "Hiển thị",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

}
