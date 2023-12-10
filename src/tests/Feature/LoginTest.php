<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Login success.
     */
    public function test_login_success(): void
    {
        $user = User::factory()->create(['password' => bcrypt('123456')]);

        $response = $this->post('/api/session', [
            'email' => $user->email,
            'password' => '123456',
        ]);

        $response->assertStatus(200);

        $response->assertJson(
            fn (AssertableJson $json) =>
            $json
                ->where('ok', true)
                ->has(
                    'data',
                    fn (AssertableJson $json) =>
                    $json
                        ->where('user.id', $user->id)
                        ->where('user.name', $user->name)
                        ->where('user.email', $user->email)
                        ->has('access_token')
                        ->has('refresh_token')
                )
        );
    }
}
