<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\WithFaker;


class ProductTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    public function test_can_create_product()
    {
        $response = $this->postJson('/api/products', [
            'sku' => 'test-sku-1',
            'name' => 'Test Product',
            'description' => 'Test desc',
            'price' => 100,
            'stock_quantity' => 20,
            'low_stock_threshold' => 10,
            'status' => 'active',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data',
            ]);
    }

    public function test_can_get_products_list()
    {
        \App\Models\Product::factory()->count(3)->create();

        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function test_can_show_product()
    {
        $product = \App\Models\Product::factory()->create();

        $response = $this->getJson("/api/products/{$product->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function test_can_update_product()
    {
        $product = \App\Models\Product::factory()->create();

        $response = $this->putJson("/api/products/{$product->id}", [
            'sku' => 'updated-sku-' . uniqid(),
            'name' => 'Updated Product',
            'description' => 'Updated desc',
            'price' => 200,
            'stock_quantity' => 30,
            'low_stock_threshold' => 10,
            'status' => 'active',
        ]);

        $response->assertStatus(200);
    }

    public function test_can_adjust_stock()
    {
        $product = \App\Models\Product::factory()->create([
            'stock_quantity' => 20,
            'low_stock_threshold' => 10,
        ]);

        $response = $this->postJson("/api/products/{$product->id}/stock", [
            'type' => 'decrement',
            'quantity' => 5,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock_quantity' => 15,
        ]);
    }
}
