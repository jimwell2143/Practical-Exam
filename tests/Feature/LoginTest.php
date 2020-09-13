<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testUserLoginValidation()
    {
        $response = $this->post('/api/login');
        $response->assertStatus(400)
                 ->assertJson([
                    'message' => [
                        'email' => ['The email field is required.'],
                        'password' => ['The password field is required.'],
                    ]
                 ]);
    }

    public function testUserFailedogin()
    {
        $payload = ['email' => 'testFailedlogin@gmail.com', 'password' => 'testFailedlogin'];
        $response = $this->post('/api/login', $payload);
        $response->assertStatus(401)
                 ->assertJson([
                    'errors' => [
                        'message' => 'Invalid Credentials',
                        'code' => 401,
                    ]
                 ]);
    }

    public function testUserSuccessLogin()
    {
        $user = User::where('email', 'testlogin@gmail.com')->first();
        if ($user === null) {
            $user = factory(User::class)->create([
                'email' => 'testlogin@gmail.com',
                'password' => 'password',
            ]);
        }
        $payload = ['email' => 'testlogin@gmail.com', 'password' => 'password'];
        $response = $this->post('/api/login', $payload);
        $response->assertStatus(201)
                 ->assertJsonStructure([
                        'access_token',
                        'token_type'
                 ]);
    }

}
