<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'River Sand', 'name_si' => 'ගඟ වැලි', 'unit' => 'Cube', 'unit_price' => 9500, 'stock_quantity' => 200],
            ['name' => 'Quarry Dust', 'name_si' => 'කුවාරි දූවිලි', 'unit' => 'Cube', 'unit_price' => 6500, 'stock_quantity' => 150],
            ['name' => 'Metal 3/4"', 'name_si' => 'මෙටල් 3/4"', 'unit' => 'Cube', 'unit_price' => 8500, 'stock_quantity' => 180],
            ['name' => 'Metal 1/2"', 'name_si' => 'මෙටල් 1/2"', 'unit' => 'Cube', 'unit_price' => 8200, 'stock_quantity' => 160],
            ['name' => 'Rubble', 'name_si' => 'රුබල්', 'unit' => 'Lorry', 'unit_price' => 15000, 'stock_quantity' => 50],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(['name' => $product['name']], $product);
        }
    }
}
