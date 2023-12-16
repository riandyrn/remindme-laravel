<?php

use App\Models\Reminder;
use App\Models\User;
use App\Services\ReminderService;

test('list reminder return array', function () {
    $user = User::factory()->create();
    Reminder::factory()
        ->for($user)
        ->create();

    $service = new ReminderService();

    $list = $service->listReminder($user->id, 10);

    expect(count($list))->toBe(1);
});

test('create reminder return created reminder', function () {
    $user = User::factory()->create();

    $service = new ReminderService();

    $remind_at = now();
    $event_at = now()->addHour();
    $list = $service->createReminder($user->id, [
        'title' => 'title',
        'description' => 'description',
        'remind_at' => $remind_at->timestamp,
        'event_at' => $event_at->timestamp,
    ]);

    expect($list->title)->toBe('title');
    expect($list->description)->toBe('description');
    expect($list->remind_at->timestamp)->toBe($remind_at->timestamp);
    expect($list->event_at->timestamp)->toBe($event_at->timestamp);

    $this->assertDatabaseHas('reminders', [
        'user_id' => $user->id,
        'title' => 'title',
        'description' => 'description',
        'remind_at' => $remind_at->toDateTimeString(),
        'event_at' => $event_at->toDateTimeString(),
    ]);
});

test('update reminder return updated reminder', function () {
    $user = User::factory()->create();
    $reminder = Reminder::factory()->for($user)->create();

    $service = new ReminderService();

    $list = $service->updateReminder($reminder, [
        'title' => 'title 2',
        'description' => 'description 2',
    ]);

    expect($list->title)->toBe('title 2');
    expect($list->description)->toBe('description 2');
    expect($list->remind_at->timestamp)->toBe($reminder->remind_at->timestamp);
    expect($list->event_at->timestamp)->toBe($reminder->event_at->timestamp);

    $this->assertDatabaseHas('reminders', [
        'user_id' => $user->id,
        'title' => 'title 2',
        'description' => 'description 2',
        'remind_at' => $reminder->remind_at->toDateTimeString(),
        'event_at' => $reminder->event_at->toDateTimeString(),
    ]);
});
