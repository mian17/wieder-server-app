<?php

namespace Database\Seeders;

use App\Models\Merchant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MerchantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Merchant::create(['name' => fake()->company(), 'address' => fake()->streetAddress(), 'phone_number' => fake()->phoneNumber(), 'email' => fake()->companyEmail()]);
        Merchant::create(['name' => fake()->company(), 'address' => fake()->streetAddress(), 'phone_number' => fake()->phoneNumber(), 'email' => fake()->companyEmail()]);
        Merchant::create(['name' => fake()->company(), 'address' => fake()->streetAddress(), 'phone_number' => fake()->phoneNumber(), 'email' => fake()->companyEmail()]);
        Merchant::create(['name' => fake()->company(), 'address' => fake()->streetAddress(), 'phone_number' => fake()->phoneNumber(), 'email' => fake()->companyEmail()]);
        Merchant::create(['name' => fake()->company(), 'address' => fake()->streetAddress(), 'phone_number' => fake()->phoneNumber(), 'email' => fake()->companyEmail()]);
    }
}
