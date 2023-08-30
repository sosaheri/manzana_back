<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductStoreTest extends TestCase
{
    use RefreshDatabase;

    public function testRegistrarProductos()
    {
        $user = User::create([
            'name' => 'Nombre',
            'lastname' => 'Apellido',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $token = JWTAuth::fromUser($user);

        $productData = [
            'name' => 'Producto',
            'url_img' => 'http://example.com/img.jpg',
            'description' => 'Descripción del producto',
        ];

        $response = $this->json('POST', 'http://localhost/api/products', $productData, ['Authorization' => "Bearer $token"]);

        $response->assertStatus(201);

        $response->assertJson([
            'success' => true,
            'message' => 'Product created successfully',
        ]);

        $this->assertDatabaseHas('products', $productData);
    }
}
