<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        for ($i = 0; $i < 50; $i++) {
            DB::table('products')->insert([
                'id' => Str::uuid(),
                'sku' => 'SKU-' . strtoupper(Str::random(8)),
                'name' => 'Product ' . ($i + 1),
                'description' => 'This is description for product ' . ($i + 1),
                'price' => rand(100, 1000),
                'stock_quantity' => rand(0, 100),
                'low_stock_threshold' => 10,
                'status' => rand(0, 1) ? 'active' : 'inactive',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
