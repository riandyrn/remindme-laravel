<?php

use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;

test('login func return token and user', function () {
    $user = User::factory()->create();

    $authService = new AuthService();
    $login = $authService->login([
        'email' => $user->email,
        'password' => 'password'
    ]);

    expect($login['access_token'])->not->toBeNull();
    expect($login['refresh_token'])->not->toBeNull();
    expect($login['user']['email'])->toBe($user->email);

    $this->assertDatabaseCount('personal_access_tokens', 2);
});

test('refreshToken func return access_token', function () {
    $user = User::factory()->create();

    $request = new Request();
    $request->setUserResolver(function () use ($user) {
        return $user;
    });

    $authService = new AuthService();
    $refresh = $authService->refreshToken($request);

    expect($refresh['access_token'])->not->toBeNull();

    $this->assertDatabaseCount('personal_access_tokens', 1);
});
