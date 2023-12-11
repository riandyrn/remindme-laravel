<?php

namespace App\Jobs;

use App\Models\Reminder;
use App\Notifications\SendReminderNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class SendReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $id;

    /**
     * Create a new job instance.
     */
    public function __construct(int $id)
    {
        $this->id = $id;

        $this->onConnection('database');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $reminder = Reminder::query()
            ->find($this->id);
        if (empty($reminder)) {
            Log::error('Reminder not found: ' . $this->id);
            return;
        }

        Notification::sendNow($reminder->user, new SendReminderNotification($reminder));
        $reminder->is_reminded = true;
        $reminder->save();
    }
}
