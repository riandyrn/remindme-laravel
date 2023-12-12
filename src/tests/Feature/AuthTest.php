<?php

use App\Helpers\Constant;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

test('can_login', function () {
    $user = User::factory()->create();

    postJson('api/session', [
        'email' => $user->email,
        'password' => 'password',
    ])->assertStatus(Response::HTTP_OK)
        ->assertJson(
            fn (AssertableJson $json) => $json
                ->where('data.user.id', $user->id)
                ->where('data.user.name', $user->name)
                ->where('data.user.email', $user->email)
                ->where('ok', true)
                ->has('data.access_token')
                ->has('data.refresh_token')
                ->etc()
        );
});

test('cant_login', function () {
    $user = User::factory()->create();

    postJson('api/session', [
        'email' => $user->email,
        'password' => 'password1',
    ])->assertStatus(Response::HTTP_UNAUTHORIZED)
        ->assertJson(
            fn (AssertableJson $json) => $json
                ->where('ok', false)
                ->where('err', Constant::ERR_INVALID_CREDS)
                ->where('msg', 'incorrect username or password')
                ->etc()
        );
});

test('can_refresh_access_token', function () {
    $user = User::factory()->create();

    Sanctum::actingAs($user, [Constant::CAN_ISSUE_ACCESS_TOKEN]);

    // $refreshToken = $user->createToken('refresh_token', [Constant::CAN_ISSUE_ACCESS_TOKEN], now()->addSeconds(Constant::REFRESH_TOKEN_TTL));
    // $user->withAccessToken($refreshToken->accessToken);
    // app('auth')->guard('sanctum')->setUser($user);
    // app('auth')->shouldUse('sanctum');

    putJson('api/session')->assertStatus(Response::HTTP_OK)
        ->assertJson(fn (AssertableJson $json) => $json
            ->where('ok', true)
            ->has('data.access_token')
            ->etc());
});

test('cant_refresh_access_token', function () {
    $user = User::factory()->create();

    Sanctum::actingAs($user, [Constant::CAN_ACCESS_API]);

    putJson('api/session')->assertStatus(Response::HTTP_UNAUTHORIZED)
        ->assertJson(fn (AssertableJson $json) => $json
            ->where('ok', false)
            ->where('err', Constant::ERR_INVALID_REFRESH_TOKEN)
            ->where('msg', 'invalid refresh token')
            ->etc());
});
