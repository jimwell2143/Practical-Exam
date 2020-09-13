<?php

namespace Tests\Feature;

use auth;
use App\User;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testOrderSuccess()
    {
        $user = User::find(1);
        $token = $token = auth()->attempt(['email' => $user->email, 'password' => 'password']);
        $headers = ['Authorization' => "Bearer $token"];
        
        $payload = [
            'product_id' => 1,
            'quantity' => 1,
        ];

        $response = $this->post('/api/order', $payload, $headers);
        
        if($response->getStatusCode() == 400){
            $response->assertStatus(400)
                     ->assertJson([
                        'errors' => [
                            'message' => 'Failed to order this product due to unavailability of the stock',
                            'code' => 400,
                        ]
                     ]);    
        }else{
            $response->assertStatus(201)
                     ->assertJson([
                         'message' => 'You have successfully ordered this product' 
                     ]);    
        }
       
    }

}
