<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'phone' => '1234556786',
            'email' => 'admin@admin.com',
            'profile' => 'ADMIN',
            'status' => 'ACTIVE',
            'password' => bcrypt('admin123')
        ]);

        User::create([
            'name' => 'yolimar Hernandez',
            'phone' => '1234545345',
            'email' => 'yolimar@yolimar.com',
            'profile' => 'EMPLOYEE',
            'status' => 'ACTIVE',
            'password' => bcrypt('123456')
        ]);
    }
}
