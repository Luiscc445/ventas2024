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
        Category::create([
            'name' => 'ROPA',
            'image' => 'https://dummyimage.com/200x150/eddced/000005'
        ]);

        Category::create([
            'name' => 'TENIS',
            'image' => 'https://dummyimage.com/200x150/eddced/000005'
        ]);

        Category::create([
            'name' => 'PANTALON',
            'image' => 'https://dummyimage.com/200x150/eddced/000005'
        ]);
    }
}
