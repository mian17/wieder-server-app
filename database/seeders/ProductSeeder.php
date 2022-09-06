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

        Product::create([
            'name' => 'Dưa hấu',
            'brand' => 'New Zealand WholeFood',
            'category_id' => 18,
//            'warehouse_id_group' => $warehouse_groups[rand(0, 9)],
            'summary' => fake()->text(),
            'desc' => fake()->paragraph(),
            'detail_info' => fake()->paragraph(),
//            'quantity' => fake()->numberBetween(1, 5000),
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
            'brand' => 'New Zealand WholeFood',
            'category_id' => 19,
//            'warehouse_id_group' => $warehouse_groups[rand(0, 9)],
            'summary' => fake()->text(),
            'desc' => fake()->paragraph(),
            'detail_info' => fake()->paragraph(),
//            'quantity' => fake()->numberBetween(1, 5000),
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
            'brand' => 'New Zealand WholeFood',
            'category_id' => 18,
//            'warehouse_id_group' => $warehouse_groups[rand(0, 9)],
            'summary' => fake()->text(),
            'desc' => fake()->paragraph(),
            'detail_info' => fake()->paragraph(),
//            'quantity' => fake()->numberBetween(1, 5000),
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
            'brand' => 'New Zealand WholeFood',
            'category_id' => 19,
//            'warehouse_id_group' => $warehouse_groups[rand(0, 9)],
            'summary' => fake()->text(),
            'desc' => fake()->paragraph(),
            'detail_info' => fake()->paragraph(),
//            'quantity' => fake()->numberBetween(1, 5000),
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
            'brand' => 'New Zealand WholeFood',
            'category_id' => 18,
//            'warehouse_id_group' => $warehouse_groups[rand(0, 9)],
            'summary' => fake()->text(),
            'desc' => fake()->paragraph(),
            'detail_info' => fake()->paragraph(),
//            'quantity' => fake()->numberBetween(1, 5000),
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
            'brand' => 'New Zealand WholeFood',
            'category_id' => 19,
//            'warehouse_id_group' => $warehouse_groups[rand(0, 9)],
            'summary' => fake()->text(),
            'desc' => fake()->paragraph(),
            'detail_info' => fake()->paragraph(),
//            'quantity' => fake()->numberBetween(1, 5000),
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
            'brand' => 'New Zealand WholeFood',
            'category_id' => 21,
//            'warehouse_id_group' => $warehouse_groups[rand(0, 9)],
            'summary' => fake()->text(),
            'desc' => fake()->paragraph(),
            'detail_info' => fake()->paragraph(),
//            'quantity' => fake()->numberBetween(1, 5000),
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
            'brand' => 'New Zealand WholeFood',
            'category_id' => 25,
//            'warehouse_id_group' => $warehouse_groups[rand(0, 9)],
            'summary' => fake()->text(),
            'desc' => fake()->paragraph(),
            'detail_info' => fake()->paragraph(),
//            'quantity' => fake()->numberBetween(1, 5000),
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
            'brand' => 'New Zealand WholeFood',
            'category_id' => 26,
//            'warehouse_id_group' => $warehouse_groups[rand(0, 9)],
            'summary' => fake()->text(),
            'desc' => fake()->paragraph(),
            'detail_info' => fake()->paragraph(),
//            'quantity' => fake()->numberBetween(1, 5000),
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
            'brand' => 'New Zealand WholeFood',
            'category_id' => 28,
//            'warehouse_id_group' => $warehouse_groups[rand(0, 9)],
            'summary' => fake()->text(),
            'desc' => fake()->paragraph(),
            'detail_info' => fake()->paragraph(),
//            'quantity' => fake()->numberBetween(1, 5000),
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
            'brand' => 'New Zealand WholeFood',
            'category_id' => 27,
//            'warehouse_id_group' => $warehouse_groups[rand(0, 9)],
            'summary' => fake()->text(),
            'desc' => fake()->paragraph(),
            'detail_info' => fake()->paragraph(),
//            'quantity' => fake()->numberBetween(1, 5000),
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
            'brand' => 'New Zealand WholeFood',
            'category_id' => 29,
//            'warehouse_id_group' => $warehouse_groups[rand(0, 9)],
            'summary' => fake()->text(),
            'desc' => fake()->paragraph(),
            'detail_info' => fake()->paragraph(),
//            'quantity' => fake()->numberBetween(1, 5000),
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
            'brand' => 'New Zealand WholeFood',
            'category_id' => 30,
//            'warehouse_id_group' => $warehouse_groups[rand(0, 9)],
            'summary' => fake()->text(),
            'desc' => fake()->paragraph(),
            'detail_info' => fake()->paragraph(),
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
            'brand' => 'New Zealand WholeFood',
            'category_id' => 31,
//            'warehouse_id_group' => $warehouse_groups[rand(0, 9)],
            'summary' => fake()->text(),
            'desc' => fake()->paragraph(),
            'detail_info' => fake()->paragraph(),
//            'quantity' => fake()->numberBetween(1, 5000),
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
