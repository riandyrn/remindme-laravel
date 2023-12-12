<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id_reminder;

    protected $email;

    protected $emailClass;

    protected $reminderRepository;

    /**
     * Create a new job instance.
     */
    public function __construct(
        $id_reminder,
        $email,
        $emailClass,
        $reminderRepository
    )
    {
        $this->id_reminder = $id_reminder;
        $this->email = $email;
        $this->emailClass = $emailClass;
        $this->reminderRepository = $reminderRepository;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)->send($this->emailClass);
        $this->reminderRepository->updateStatusDone($this->id_reminder);
    }
}
