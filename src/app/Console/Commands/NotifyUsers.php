<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\ReminderRepository;
use App\Jobs\SendMailJob;
use App\Mail\SendEmail;

class NotifyUsers extends Command
{

    private $reminderRepository;

    public function __construct(
        ReminderRepository $reminderRepository
    )
    {
        parent::__construct();
        $this->reminderRepository = $reminderRepository;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email to users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dataRemind = $this->reminderRepository->dataMustSend();
        foreach ( $dataRemind as $row ) {
            dispatch(new SendMailJob(
                $row->id,
                $row->user->email,
                new SendEmail(
                    $row->title,
                    $row->user->name,
                    $row->description
                ),
                $this->reminderRepository
            ));
        }
    }
}
