<?php

namespace Tests\Feature;

use App\Enums\TokenAbility;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class RefreshTokenTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Refresh token success.
     */
    public function test_refresh_token_success(): void
    {
        $user = User::factory()->create(['password' => bcrypt('123456')]);
        $refreshToken = $user->createToken(
            'refresh_token',
            [TokenAbility::ISSUE_ACCESS_TOKEN->value],
            Carbon::now()->addMinutes(2),
        );

        $response = $this->put('/api/session', [], [
            'Authorization' => 'Bearer ' . $refreshToken->plainTextToken,
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(200);

        $response->assertJson(
            fn (AssertableJson $json) =>
            $json
                ->where('ok', true)
                ->has(
                    'data',
                    fn (AssertableJson $json) => $json->has('access_token')
                )
        );
    }
}
