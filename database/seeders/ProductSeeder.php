<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name' => 'Samsung Galaxy Buds',
            'cost' => 200,
            'price' => 350,
            'barcode' => '12342345',
            'stock' => 1000,
            'alert' => 10,
            'category_id' => 1, 
            'image' => 'camisa.png'
        ]);

        Product::create([
            'name' => 'Apple Air Pods',
            'cost' => 200,
            'price' => 350,
            'barcode' => '1234232345',
            'stock' => 1000,
            'alert' => 10,
            'category_id' => 3, 
            'image' => 'camisa.png'
        ]);

        Product::create([
            'name' => 'Daewoo',
            'cost' => 200,
            'price' => 350,
            'barcode' => '12342354645',
            'stock' => 1000,
            'alert' => 10,
            'category_id' => 2, 
            'image' => 'camisa.png'
        ]);
    }
}
