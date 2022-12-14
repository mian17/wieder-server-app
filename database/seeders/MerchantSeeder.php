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
        Merchant::create([
            'name' => 'Wieder_ Official Store',
            'address' => '68 Nguyễn Thị Minh Khai, Quận 1, TP. HCM',
            'phone_number' => '0586801768',
            'email' => 'alibis_intron.0x@icloud.com'
        ]);
        $iterationCount = 5;
        for ($i = 0; $i < $iterationCount; $i++) {
            Merchant::create([
                'name' => fake()->company(),
                'address' => fake()->streetAddress(),
                'phone_number' => fake()->phoneNumber(),
                'email' => fake()->companyEmail()]);
        }
    }
}
