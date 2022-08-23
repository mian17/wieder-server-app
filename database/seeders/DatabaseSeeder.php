<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            UserRoleSeeder::class,
            CategorySeeder::class,
            MerchantSeeder::class,
            DiscountSeeder::class
        ]);

        User::create([
            'username' => 'admin',
            'password' => '12345678', // password
            'email' => 'vinh.lethe_1997@icloud.com',
            'phone_number' => '0586801768',
            'name' => 'Lê Thế Vinh',
            'birth_date' => '1997-01-22',
            'gender' => 0,
            'address' => '68 Nguyễn Thị Minh Khai, Quận 1, TP. HCM',
            'reward_points' => 0,
            'email_verified_at' => now()
        ]);

        User::factory(10)->create();




        $admin = User::where('username', 'admin')->first();

        $adminRole = UserRole::where('role_name', 'Admin')->first();
        $moderatorRole = UserRole::where('role_name', 'Quản trị viên')->first();
        $customerRole = UserRole::where('role_name', 'Khách hàng')->first();

        $roles = [$adminRole, $moderatorRole, $customerRole];

        $admin->roles()->attach($adminRole);
        $admin->roles()->attach($moderatorRole);
        $admin->roles()->attach($customerRole);

        foreach(User::all() as $user) {
            if ($user->username === 'admin') continue;
            $user->roles()->attach($roles[rand(0, 2)]);
        }







    }
}
