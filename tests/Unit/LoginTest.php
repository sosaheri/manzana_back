<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testUsuarioLoguea()
    {
        $user = User::create([
            'name' => 'Nombre',
            'lastname' => 'Apellido',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $loginData = [
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        $response = $this->json('POST', 'http://localhost/api/login', $loginData);

        $response->assertStatus(200);

        $this->assertArrayHasKey('token', $response->json());

        $this->assertEquals($user->id, JWTAuth::setToken($response->json('token'))->authenticate()->id);
    }
}
