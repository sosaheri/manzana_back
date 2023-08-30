<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class GetUserInfoTest extends TestCase
{
    use RefreshDatabase;

    public function testObtengoInfoUsuario()
    {
        $user = User::create([
            'name' => 'Nombre',
            'lastname' => 'Apellido',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $token = JWTAuth::fromUser($user);

        $response = $this->json('GET', 'http://localhost/api/get_user', [], ['Authorization' => "Bearer $token"]);

        $response->assertStatus(200);

        $response->assertJson(['user' => $user->toArray()]);
    }
}
