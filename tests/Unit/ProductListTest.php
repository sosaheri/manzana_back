<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductListTest extends TestCase
{
    use RefreshDatabase;

    public function testObtengoListaProductos()
    {
        $user = User::create([
            'name' => 'Nombre',
            'lastname' => 'Apellido',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $token = JWTAuth::fromUser($user);

        $product1 = Product::create(['name' => 'Producto 1', 'url_img' => 'http://img.png', 'description' => "Description Producto 1"]);
        $product2 = Product::create(['name' => 'Producto 2', 'url_img' => 'http://img.png', 'description' => "Description Producto 2"]);

        $response = $this->json('GET', 'http://localhost/api/products', [], ['Authorization' => "Bearer $token"]);

        $response->assertStatus(200);

        $response->assertJson([$product1->toArray(), $product2->toArray()]);
    }
}
