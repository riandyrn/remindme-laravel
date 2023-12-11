<?php

namespace App\Console\Commands;

use App\Jobs\SendReminderJob;
use App\Models\Reminder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Reminder to email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $reminders = Reminder::query()
            ->with('user')
            ->where('is_reminded', false)
            ->where('remind_at', '<=', now())
            ->get();
        /** @var Reminder $reminder */
        foreach ($reminders as $reminder) {
            Log::info(sprintf("Sending event with ID %d", $reminder->id));
            SendReminderJob::dispatch($reminder->id);
        }
    }
}
