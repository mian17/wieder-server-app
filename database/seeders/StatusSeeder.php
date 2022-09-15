<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::create(['name' => "Chờ xác nhận"]);
        Status::create(['name' => "Chờ lấy hàng"]);
        Status::create(['name' => "Đang giao"]);
        Status::create(['name' => "Đã giao"]);
        Status::create(['name' => "Đã hủy"]);
        Status::create(['name' => "Yêu cầu đổi trả, hoàn tiền"]);
    }
}
