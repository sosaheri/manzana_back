<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function testUsuarioDesloguea()
    {
        $user = User::create([
            'name' => 'Nombre',
            'lastname' => 'Apellido',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $token = JWTAuth::fromUser($user);

        $response = $this->json('GET', 'http://localhost/api/logout', [], ['Authorization' => "Bearer $token"]);

        $response->assertStatus(200);

        $response->assertJson([
            'success' => true,
            'message' => 'Usuario salio exitosamente del sistema',
        ]);

        $this->assertFalse(JWTAuth::setToken($token)->check());
    }
}
