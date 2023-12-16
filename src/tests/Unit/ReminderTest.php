<?php

use App\Jobs\SendReminderJob;
use App\Models\Reminder;
use App\Notifications\SendReminderNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;

test('can_send_reminder', function () {
    Queue::fake();

    $reminder = Reminder::factory()->create();

    Carbon::setTestNow(now()->addMinutes(5));

    $this->artisan('send-reminder')->assertExitCode(0);

    Queue::assertPushed(SendReminderJob::class, 1);
});

test('can_send_notification', function () {
    Notification::fake();

    $reminder = Reminder::factory()->create();

    Carbon::setTestNow(now()->addMinutes(5));

    $this->artisan('send-reminder')->assertExitCode(0);

    Notification::assertSentTo(
        [$reminder->user],
        SendReminderNotification::class
    );

    $this->assertDatabaseHas('reminders', [
        'id' => $reminder->id,
        'is_reminded' => true
    ]);
});

test('dont_send_reminder_already_reminded', function () {
    Queue::fake();

    Reminder::factory()->create([
        'is_reminded' => true
    ]);

    Carbon::setTestNow(now()->addMinutes(5));

    $this->artisan('send-reminder')->assertExitCode(0);

    Queue::assertPushed(SendReminderJob::class, 0);
});

test('not_yet_send_reminder', function () {
    Queue::fake();

    Reminder::factory()->create([
        'remind_at' => now()->addHour()
    ]);

    Carbon::setTestNow(now()->addMinutes(5));

    $this->artisan('send-reminder')->assertExitCode(0);

    Queue::assertPushed(SendReminderJob::class, 0);
});
