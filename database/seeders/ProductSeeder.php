<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Crear 50,000 productos con factory
        Product::factory()->count(50000)->create();
    }
}
