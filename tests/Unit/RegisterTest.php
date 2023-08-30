<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testUsuarioSeRegistra()
    {
        $userData = [
            'name' => 'Nombre',
            'lastname' => 'Apellido',
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        $response = $this->json('POST', 'http://localhost/api/register', $userData);

        $response->assertStatus(201)
                 ->assertJson([
                    'success' => true,
                    'message' => 'Usuario creado exitosamente',
                 ]);

        $this->assertDatabaseHas('users', [
            'name' => $userData['name'],
            'lastname' => $userData['lastname'],
            'email' => $userData['email'],
        ]);
    }
}
