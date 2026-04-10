<?php

namespace Database\Factories;

use App\Models\Product;
use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'id' => (string) Str::uuid(),
            'sku' => $this->faker->unique()->lexify('SKU-??????'),
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'stock_quantity' => $this->faker->numberBetween(0, 100),
            'low_stock_threshold' => $this->faker->numberBetween(10, 20),
            'status' => $this->faker->randomElement([
                ProductStatus::ACTIVE->value,
                ProductStatus::INACTIVE->value,
                ProductStatus::DISCONTINUED->value
            ]),
        ];
    }
}
