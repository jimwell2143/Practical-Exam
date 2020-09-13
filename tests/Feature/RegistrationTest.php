<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testsUserRegisterSuccess()
    {
        $payload = [
            'email' =>  $this->faker->unique()->safeEmail,
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->post('/api/register', $payload);
        $response->assertStatus(201)
                 ->assertJson([
                    'message' => 'User successfully registered' 
                 ]);
    }

    public function testsUserRegisterEmailValidation()
    {
        $user = User::find(1);
        $payload = [
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->post('/api/register', $payload);
        $response->assertStatus(400)
                 ->assertJson([
                    'message' => [
                        'email' => ['The email has already been taken.'],
                    ]
                ]);
    }
}
