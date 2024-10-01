<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::updateOrCreate(
            ['name' => 'BLUETOOTH'],
            ['image' => 'https://ibb.co/rtQVwCK']
        );

        Category::updateOrCreate(
            ['name' => 'CABLE'],
            ['image' => 'https://ibb.co/p1TZrSF']
        );

        Category::updateOrCreate(
            ['name' => 'MESA'],
            ['image' => 'https://ibb.co/yfb7JTy']
        );
    }
}
