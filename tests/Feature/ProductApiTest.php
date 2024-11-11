<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_products()
    {
        Product::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/products');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'price',
                        'created_at',
                    ]
                ]
            ]);
    }

    public function test_can_get_single_product()
    {
        $product = Product::factory()->create();

        $response = $this->getJson('/api/v1/products/' . $product->id);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'created_at' => $product->created_at,
                ]
            ]);
    }

    public function test_can_create_product()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $data = [
            'name' => 'New Product',
            'price' => 100
        ];

        $response = $this->postJson('/api/v1/products', $data, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'data' => $data
            ]);
    }

    public function test_can_update_product()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $product = Product::factory()->create();

        $data = [
            'name' => 'Updated Product',
            'price' => 150
        ];

        $response = $this->putJson('/api/v1/products/' . $product->id, $data, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => $data
            ]);
    }

    public function test_can_delete_product()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $product = Product::factory()->create();

        $response = $this->deleteJson('/api/v1/products/' . $product->id, [], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(204);
    }
}
