<?php

namespace Database\Seeders;

use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserRole::create(['role_name' => 'admin', 'upper_role_id' => null]);
        UserRole::create(['role_name' => 'moderator', 'upper_role_id' => 1]);
        UserRole::create(['role_name' => 'customer', 'upper_role_id' => 2]);
    }
}
