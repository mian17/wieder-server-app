<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentMethod::create(['name' => 'Thanh toán tiền mặt']);
        PaymentMethod::create(['name' => 'Ví MoMo']);
        PaymentMethod::create(['name' => 'Ví ZaloPay']);
        PaymentMethod::create(['name' => 'Ví Moca|Grab']);
        PaymentMethod::create(['name' => 'VNPAY']);
        PaymentMethod::create(['name' => 'Thẻ tín dụng/Ghi nợ']);
        PaymentMethod::create(['name' => 'Thẻ ATM']);
    }
}
