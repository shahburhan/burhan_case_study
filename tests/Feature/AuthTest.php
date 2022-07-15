<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;

class AuthTest extends TestCase
{
    use WithFaker;

    /**
     * Test Login without credentials
     *
     * @return void
     */
    public function test_login_attempt_without_credentials()
    {
        $response = $this->postJson('api/auth/login');

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'email', 'password'
        ]);
    }

    /**
     * Test wrong credentials.
     *
     * @return void
     */
    public function test_login_attempt_with_wrong_credentials()
    {
        $response = $this->postJson('api/auth/login', ['email'=> 'example@example.com', 'password' => 'password']);

        $response->assertStatus(401);
        $response->assertExactJson(['message'=>'Invalid credentials']);
    }

    /**
     * Test successful login.
     *
     * @return void
     */
    public function test_login_attempt_with_correct_credentials()
    {
        $password = $this->faker->password();
        $user     = User::create(
            [
                'name'     => $this->faker->name(),
                'email'    => $this->faker->email(),
                'password' => Hash::make($password),
            ]
        );

        $response = $this->postJson('api/auth/login', ['email'=> $user->email, 'password' => $password]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'token'
        ]);
    }
}
