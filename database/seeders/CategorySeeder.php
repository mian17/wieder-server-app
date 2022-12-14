<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Trái cây',
            'img_url' => '/img/categories/0-category-fruits.jpg',
            'parent_category_id' => null,
        ]);

        Category::create([
            'name' => 'Thịt, trứng',
            'img_url' => '/img/categories/1-category-meat.jpg',
            'parent_category_id' => null,
        ]);
        Category::create([
            'name' => 'Cá, thủy hải sản',
            'img_url' => '/img/categories/2-category-seafood.jpg',
            'parent_category_id' => null,
        ]);
        Category::create([
            'name' => 'Rau củ quả',
            'img_url' => '/img/categories/3-category-vegetable.jpg',
            'parent_category_id' => null,
        ]);
        Category::create([
            'name' => 'Thực phẩm Việt',
            'img_url' => '/img/categories/4-category-vietnamese-food.jpg',
            'parent_category_id' => null,
        ]);
        Category::create([
            'name' => 'Sữa, Bơ, Phô Mai',
            'img_url' => '/img/categories/5-category-dairy.jpg',
            'parent_category_id' => null,
        ]);
        Category::create([
            'name' => 'Đông lạnh, mát',
            'img_url' => '/img/categories/6-category-frozen-food.jpg',
            'parent_category_id' => null,
        ]);

        Category::create([
            'name' => 'Dầu ăn, gia vị',
            'img_url' => '/img/categories/7-category-cooking-oil-spice.jpg',
            'parent_category_id' => null,
        ]);
        Category::create([
            'name' => 'Gạo, Mì, Nông sản',
            'img_url' => '/img/categories/8-category-rice-noodle-agriculture-products.jpg',
            'parent_category_id' => null,
        ]);
        Category::create([
            'name' => 'Đồ hộp, Đóng gói',
            'img_url' => '/img/categories/9-category-canned-foods.jpg',
            'parent_category_id' => null,
        ]);
        Category::create([
            'name' => 'Bia, Đồ uống',
            'img_url' => '/img/categories/10-category-beer-drinks.jpg',
            'parent_category_id' => null,
        ]);
        Category::create([
            'name' => 'Thực phẩm chay',
            'img_url' => '/img/categories/11-category-vegetarian-food.jpg',
            'parent_category_id' => null,
        ]);
        Category::create([
            'name' => 'Dành cho trẻ em',
            'img_url' => '/img/categories/12-category-things-for-kids.jpg',
            'parent_category_id' => null,
        ]);
        Category::create([
            'name' => 'Bánh kẹo, Giỏ quà',
            'img_url' => '/img/categories/13-category-sweets-snacks-gifts.jpg',
            'parent_category_id' => null,
        ]);
        Category::create([
            'name' => 'Thức ăn, Đồ thú cưng',
            'img_url' => '/img/categories/14-category-food-things-for-pets.jpg',
            'parent_category_id' => null,
        ]);
        Category::create([
            'name' => 'Chăm sóc cá nhân',
            'img_url' => '/img/categories/15-category-self-care.jpg',
            'parent_category_id' => null,
        ]);
        Category::create([
            'name' => 'Chăm sóc nhà cửa',
            'img_url' => '/img/categories/16-category-home-appliance.jpg',
            'parent_category_id' => null,
        ]);
        Category::create([
            'name' => 'Trái cây nội địa',
            'img_url' => '/img/categories/trai-cay-noi-dia.jpg',
            'parent_category_id' => 1,
        ]);
        Category::create([
            'name' => 'Trái cây nhập khẩu',
            'img_url' => '/img/categories/trai-cay-nhap-khau.jpg',
            'parent_category_id' => 1,
        ]);
        Category::create([
            'name' => 'Thịt heo, lợn',
            'img_url' => '/img/categories/thit-heo-lon.jpg',
            'parent_category_id' => 2,
        ]);
        Category::create([
            'name' => 'Thịt bò, bê',
            'img_url' => '/img/categories/thit-bo-be.jpg',
            'parent_category_id' => 2,
        ]);

        Category::create([
            'name' => 'Thịt gà, vịt, chim',
            'img_url' => '/img/categories/thit-ga-vit-chim.jpg',
            'parent_category_id' => 2,
        ]);
        Category::create([
            'name' => 'Thịt đông lạnh',
            'img_url' => '/img/categories/thit-dong-lanh.jpg',
            'parent_category_id' => 2,
        ]);
        Category::create([
            'name' => 'Các loại thịt khác',
            'img_url' => '/img/categories/cac-loai-thit-khac.jpg',
            'parent_category_id' => 2,
        ]);
        Category::create([
            'name' => 'Trứng gà, vịt, cút',
            'img_url' => '/img/categories/trung-ga-vit-cut.jpg',
            'parent_category_id' => 2,
        ]);
        Category::create([
            'name' => 'Cá, hải sản đông lạnh',
            'img_url' => '/img/categories/ca-hai-san-dong-lanh.jpg',
            'parent_category_id' => 3,
        ]);
        Category::create([
            'name' => 'Củ, quả, măng tươi',
            'img_url' => '/img/categories/cu-qua-mang-tuoi.jpg',
            'parent_category_id' => 4,
        ]);
        Category::create([
            'name' => 'Gạo, nếp, đậu',
            'img_url' => '/img/categories/gao-nep-dau.jpg',
            'parent_category_id' => 9,
        ]);
        Category::create([
            'name' => 'Bột gạo, mì, bột chiên',
            'img_url' => '/img/categories/bot-gao-mi-bot-chien.jpg',
            'parent_category_id' => 9,
        ]);



        Category::create([
            'name' => 'Trà khô, trà đóng chai',
            'img_url' => '/img/categories/tra-kho-tra-dong-chai.jpg',
            'parent_category_id' => 11,
        ]);
        Category::create([
            'name' => 'Cà phê hạt, đóng chai',
            'img_url' => '/img/categories/ca-phe-hat-dong-chai.jpg',
            'parent_category_id' => 11,
        ]);
    }
}
