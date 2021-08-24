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
            'name' => 'Jaiver Ramos',
            'phone' => '1234556786',
            'email' => 'jaiver@jaiver.com',
            'profile' => 'ADMIN',
            'status' => 'ACTIVE',
            'password' => bcrypt('Jjra.2121')
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
