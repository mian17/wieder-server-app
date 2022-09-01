<?php

namespace Database\Seeders;

use App\Models\Kind;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KindSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kind::create([
            'name' => 'Dưa hấu',
            'image_1' => '/img/product/dua-hau-1.jpg',
            'image_2' => '/img/product/dua-hau-2.jpg',
            'hex_color' => '#fa5252',
            'product_id' => 1
        ]);
        Kind::create([
            'name' => 'Dâu tây',
            'image_1' => '/img/product/dau-tay-1.jpg',
            'image_2' => '/img/product/dau-tay-2.jpg',
            'hex_color' => '#fa5252',
            'product_id' => 2
        ]);
        Kind::create([
            'name' => 'Măng cụt',
            'image_1' => '/img/product/mang-cut-1.jpg',
            'image_2' => '/img/product/mang-cut-2.jpg',
            'hex_color' => '#ced4da',
            'product_id' => 3
        ]);
        Kind::create([
            'name' => 'Chanh nhập khẩu',
            'image_1' => '/img/product/chanh-1.jpg',
            'image_2' => '/img/product/chanh-2.jpg',
            'hex_color' => '#ffd43b',
            'product_id' => 4
        ]);
        Kind::create([
            'name' => 'Thanh long',
            'image_1' => '/img/product/thanh-long-1.jpg',
            'image_2' => '/img/product/thanh-long-2.jpg',
            'hex_color' => '#ff6b6b',
            'product_id' => 5
        ]);
        Kind::create([
            'name' => 'Táo đỏ',
            'image_1' => '/img/product/tao-do-1.jpg',
            'image_2' => '/img/product/tao-do-2.jpg',
            'hex_color' => '#ff8787',
            'product_id' => 6
        ]);
        Kind::create([
            'name' => 'Táo xanh',
            'image_1' => '/img/product/tao-xanh-1.jpg',
            'image_2' => '/img/product/tao-xanh-2.jpg',
            'hex_color' => '#51cf66',
            'product_id' => 6
        ]);
        Kind::create([
            'name' => 'Thịt bò',
            'image_1' => '/img/product/thit-bo-1.jpg',
            'image_2' => '/img/product/thit-bo-2.jpg',
            'hex_color' => '#ff8787',
            'product_id' => 7
        ]);
        Kind::create([
            'name' => 'Trứng gà',
            'image_1' => '/img/product/trung-ga-1.jpg',
            'image_2' => '/img/product/trung-ga-2.jpg',
            'hex_color' => '#ff6b6b',
            'product_id' => 8
        ]);

        Kind::create([
            'name' => 'Cá hồi',
            'image_1' => '/img/product/ca-hoi-1.jpg',
            'image_2' => '/img/product/ca-hoi-1.jpg',
            'hex_color' => '#ffa94d',
            'product_id' => 9
        ]);
        Kind::create([
            'name' => 'Gạo 5kg',
            'image_1' => '/img/product/gao-1.jpg',
            'image_2' => '/img/product/gao-2.jpg',
            'hex_color' => '#ced4da',
            'product_id' => 10
        ]);
        Kind::create([
            'name' => 'Dưa leo',
            'image_1' => '/img/product/dua-leo-1.jpg',
            'image_2' => '/img/product/dua-leo-2.jpg',
            'hex_color' => '#82c91e',
            'product_id' => 11
        ]);
        Kind::create([
            'name' => 'Mì ý cọng dài',
            'image_1' => '/img/product/mi-y-cong-dai-1.jpg',
            'image_2' => '/img/product/mi-y-cong-dai-2.jpg',
            'hex_color' => '#ffe066',
            'product_id' => 12
        ]);
        Kind::create([
            'name' => 'Mì ý cọng ngắn',
            'image_1' => '/img/product/mi-y-cong-ngan-1.jpg',
            'image_2' => '/img/product/mi-y-cong-ngan-2.jpg',
            'hex_color' => '#f08c00',
            'product_id' => 12
        ]);

        Kind::create([
            'name' => 'Trà matcha đóng chai',
            'image_1' => '/img/product/tra-matcha-dang-nuoc-1.jpg',
            'image_2' => '/img/product/tra-matcha-dang-nuoc-1.jpg',
            'hex_color' => '#82c91e',
            'product_id' => 13
        ]);
        Kind::create([
            'name' => 'Cà phê dạng hạt Arabica',
            'image_1' => '/img/product/ca-phe-dang-hat-arabica-1.jpg',
            'image_2' => '/img/product/ca-phe-dang-hat-arabica-2.jpg',
            'hex_color' => '#e67700',
            'product_id' => 14
        ]);
    }
}
