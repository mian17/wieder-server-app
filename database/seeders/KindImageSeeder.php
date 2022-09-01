<?php

namespace Database\Seeders;

use App\Models\KindImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KindImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Dua hau model_id = 1
        KindImage::create([
            'model_id' => 1,
            'url' => '/img/product/dua-hau-product-1.jpg'
        ]);
        KindImage::create([
            'model_id' => 1,
            'url' => '/img/product/dua-hau-product-2.jpg'
        ]);
        KindImage::create([
            'model_id' => 1,
            'url' => '/img/product/dua-hau-product-3.jpg'
        ]);
        KindImage::create([
            'model_id' => 1,
            'url' => '/img/product/dua-hau-product-4.jpg'
        ]);
        KindImage::create([
            'model_id' => 1,
            'url' => '/img/product/dua-hau-product-5.jpg'
        ]);
        KindImage::create([
            'model_id' => 1,
            'url' => '/img/product/dua-hau-product-6.jpg'
        ]);
        KindImage::create([
            'model_id' => 1,
            'url' => '/img/product/dua-hau-product-7.jpg'
        ]);
        KindImage::create([
            'model_id' => 1,
            'url' => '/img/product/dua-hau-product-8.jpg'
        ]);
        KindImage::create([
            'model_id' => 1,
            'url' => '/img/product/dua-hau-product-9.jpg'
        ]);
        KindImage::create([
            'model_id' => 1,
            'url' => '/img/product/dua-hau-product-10.jpg'
        ]);

        // Dau tay model_id = 2
        KindImage::create([
            'model_id' => 2,
            'url' => '/img/product/dau-tay-product-1.jpg'
        ]);
        KindImage::create([
            'model_id' => 2,
            'url' => '/img/product/dau-tay-product-2.jpg'
        ]);
        KindImage::create([
            'model_id' => 2,
            'url' => '/img/product/dau-tay-product-3.jpg'
        ]);
        KindImage::create([
            'model_id' => 2,
            'url' => '/img/product/dau-tay-product-4.jpg'
        ]);
        KindImage::create([
            'model_id' => 2,
            'url' => '/img/product/dau-tay-product-5.jpg'
        ]);
        KindImage::create([
            'model_id' => 2,
            'url' => '/img/product/dau-tay-product-6.jpg'
        ]);
        KindImage::create([
            'model_id' => 2,
            'url' => '/img/product/dau-tay-product-7.jpg'
        ]);
        KindImage::create([
            'model_id' => 2,
            'url' => '/img/product/dau-tay-product-8.jpg'
        ]);
        KindImage::create([
            'model_id' => 2,
            'url' => '/img/product/dau-tay-product-9.jpg'
        ]);
        KindImage::create([
            'model_id' => 2,
            'url' => '/img/product/dau-tay-product-10.jpg'
        ]);

        // Mang cut model_id = 3
        $this->makeKindImage(3, 'mang-cut', 3);

        // Chanh nhap khau model_id = 4
        $this->makeKindImage(4, 'chanh-nhap-khau', 10);

        // Thanh long model_id = 5
        $this->makeKindImage(5, 'thanh-long', 5);

        // Tao do model_id = 6
        $this->makeKindImage(6, 'tao-do', 6);

        // Tao xanh model_id = 7
        $this->makeKindImage(7, 'tao-xanh', 6);

        // Thit bo model_id = 8
        $this->makeKindImage(8, 'thit-bo', 6);

        // Trung ga model_id = 9
        $this->makeKindImage(9, 'trung-ga', 7);

        // Ca hoi model_id = 10
        $this->makeKindImage(10, 'ca-hoi', 6);

        // Gao 5kg model_id = 11
        $this->makeKindImage(11, 'gao', 6);

        // Dua leo model_id = 12
        $this->makeKindImage(12, 'dua-leo', 6);

        // Mi y cong dai model_id = 13
        $this->makeKindImage(13, 'mi-y-cong-dai', 6);

        // Mi y cong ngan model_id = 14
        $this->makeKindImage(14, 'mi-y-cong-ngan', 6);

        // Tra matcha dong chai model_id = 15
        $this->makeKindImage(15, 'tra-matcha-dong-chai', 6);

        // Ca phe dang hat Arabica model_id = 16
        $this->makeKindImage(16, 'ca-phe-dang-hat-arabica', 6);

    }

    /**
     * Tired of copying and pasting the same code for making model product images
     *
     * @param int $modelId
     * @param string $imageNameTemplate
     * @param int $quantity
     * @return void
     */
    public function makeKindImage(int $modelId, string $imageNameTemplate, int $quantity): void
    {
        for ($i = 1; $i <= $quantity; $i++) {
            KindImage::create([
                'model_id' => $modelId,
                'url' => "/img/product/" . $imageNameTemplate . "-product-" . $i . ".jpg"
            ]);
        }
    }
}
