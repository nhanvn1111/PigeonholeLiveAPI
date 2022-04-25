<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\Passport;

class UserTest extends TestCase
{
   /**
    * required fields for registration
    * status ok
    */
    public function testRequiredFieldsForRegistration()
    {
        
        // $response = $this->json('POST', 'api/register', ['Accept' => 'application/json']);
        // dd($response->getContent());
        $this->json('POST', 'api/register', ['Accept' => 'application/json'])
        ->assertJson([
            "message" => "Validation Error.",
            "data" => [
                "name" => ["The name field is required."],
                "email" => ["The email field is required."],
                "password" => ["The password field is required."],
                "c_password" => ["The c password field is required."],
            ]
        ]);
    }

    public function testSuccessfulRegistration()
    {
        $userData = [
            "name" => "Nhan",
            "email" => "nhan9@gmail.com",
            "password" => "123456",
            "c_password" => "123456"
        ];
        // $response = $this->json('POST', 'api/register', $userData, ['Accept' => 'application/json']);
        // dd($response->getContent());
        $this->json('POST', 'api/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(200);
    }

    /**
     * required fields for registration → This test did not perform any assertions  D:\nhan_training\aspire\aspire_chanllenge\tests\Feature\UserTest.php:30
    *✓ successful login
    * status ok
     */
    public function testSuccessfulLogin()
    {
        $user = User::factory()->create([
           'email' => 'nhanvn12@gmail.com',
           'password' => bcrypt('123456'),
        ]);


        $loginData = ['email' => 'nhanvn12@gmail.com', 'password' => '123456'];

        $this->json('POST', 'api/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(200);

    }
}
