<?php

use App\Models\Reminder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

test('can_list_reminder', function () {
    $user = User::factory()->create();

    Sanctum::actingAs($user, ['*']);

    getJson('api/reminders')
        ->assertStatus(Response::HTTP_OK)
        ->assertJson(
            fn (AssertableJson $json) => $json
                ->where('ok', true)
                ->etc()
        );
});

test('can_get_reminder', function () {
    $reminder = Reminder::factory()->create();

    Sanctum::actingAs($reminder->user, ['*']);

    getJson('api/reminders/' . $reminder->id)
        ->assertStatus(Response::HTTP_OK)
        ->assertJson(
            fn (AssertableJson $json) => $json
                ->where('data.title', $reminder->title)
                ->where('data.description', $reminder->description)
                ->where('data.remind_at', $reminder->remind_at->timestamp)
                ->where('data.event_at', $reminder->event_at->timestamp)
                ->where('ok', true)
                ->etc()
        );
});

test('can_create_reminder', function () {
    $user = User::factory()->create();

    Sanctum::actingAs($user, ['*']);

    $input = [
        'title' => 'title',
        'description' => 'description',
        'remind_at' => 1702369949,
        'event_at' => 1702369949,
    ];

    postJson('api/reminders', $input)
        ->assertStatus(Response::HTTP_OK)
        ->assertJson(
            fn (AssertableJson $json) => $json
                ->where('ok', true)
                ->etc()
        );

    $this->assertDatabaseHas('reminders', [
        'user_id' => $user->id,
        'title' => 'title',
        'description' => 'description',
        'remind_at' => Carbon::createFromTimestampUTC(1702369949)->toDateTimeString(),
        'event_at' => Carbon::createFromTimestampUTC(1702369949)->toDateTimeString(),
    ]);
});

test('can_update_reminder', function () {
    $reminder = Reminder::factory()->create();
    $user = $reminder->user;

    $this->assertDatabaseHas('reminders', [
        'user_id' => $user->id,
        'title' => 'title',
        'description' => 'description',
        'remind_at' => Carbon::createFromTimestampUTC(1702369949)->toDateTimeString(),
        'event_at' => Carbon::createFromTimestampUTC(1702369949)->toDateTimeString(),
    ]);

    Sanctum::actingAs($reminder->user, ['*']);

    putJson('api/reminders/' . $reminder->id, [
        'title' => 'title 2',
        'description' => 'description 2'
    ])
        ->assertStatus(Response::HTTP_OK)
        ->assertJson(
            fn (AssertableJson $json) => $json
                ->where('ok', true)
                ->etc()
        );

    $this->assertDatabaseHas('reminders', [
        'user_id' => $user->id,
        'title' => 'title 2',
        'description' => 'description 2',
        'remind_at' => Carbon::createFromTimestampUTC(1702369949)->toDateTimeString(),
        'event_at' => Carbon::createFromTimestampUTC(1702369949)->toDateTimeString(),
    ]);
});


test('can_delete_reminder', function () {
    $reminder = Reminder::factory()->create();
    $user = $reminder->user;

    $this->assertDatabaseHas('reminders', [
        'user_id' => $user->id,
        'title' => 'title',
        'description' => 'description',
        'remind_at' => Carbon::createFromTimestampUTC(1702369949)->toDateTimeString(),
        'event_at' => Carbon::createFromTimestampUTC(1702369949)->toDateTimeString(),
    ]);

    Sanctum::actingAs($reminder->user, ['*']);

    deleteJson('api/reminders/' . $reminder->id)
        ->assertStatus(Response::HTTP_OK)
        ->assertJson(
            fn (AssertableJson $json) => $json
                ->where('ok', true)
                ->etc()
        );

    $this->assertDatabaseMissing('reminders', [
        'id' => $reminder->id,
    ]);
});
