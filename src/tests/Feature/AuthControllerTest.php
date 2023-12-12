<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Artisan::call('migrate');
    }

    public function test_user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson('/api/session', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'ok' => true,
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'email' => $user->email,
                        'name' => $user->name,
                    ],
                ],
            ])
            ->assertJsonStructure([
                'ok',
                'data' => [
                    'user' => [
                        'id',
                        'email',
                        'name',
                    ],
                    'access_token',
                    'refresh_token',
                ],
            ]);
    }

    public function test_user_cannot_login_with_invalid_credentials()
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson('/api/session', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'ok' => false,
                'err' => 'ERR_INVALID_CREDS',
                'msg' => 'Incorrect username or password',
            ]);
    }

    public function test_refreshes_access_token_successfully()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson('/api/session', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);
        // Mocking the HTTP request
        Http::fake([
            '*/api/session' => Http::response([
                'ok' => true,
                'data' => [
                    'access_token' => '933e89b1-980b-4c98-8d73-18f7ccfac25d',
                    'refresh_token' => '8eebef3c-03e0-4ead-b78e-27bac3fc43c',
                ],
            ], 200),
        ]);

        // Sending the request to refresh access token
        $response = $this->put('/api/session', [], [
            'Authorization' => 'Bearer ' . $response->json()["data"]["refresh_token"],
        ]);

        // Asserting the response
        $response->assertStatus(200)
            ->assertJson([
                'ok' => true
            ])
            ->assertJsonStructure([
                'ok',
                'data' => [
                    'access_token'
                ]
            ]);
    }
}