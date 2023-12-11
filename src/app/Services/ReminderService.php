<?php

namespace App\Services;

use App\Models\Reminder;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class ReminderService
{
    /**
     * @param integer $userId
     * @param integer $limit
     * @return Collection
     */
    public function listReminder(int $userId, int $limit): Collection
    {
        return Reminder::query()
            ->where('user_id', $userId)
            ->orderBy('remind_at')
            ->limit($limit)
            ->get();
    }

    /**
     * @param integer $userId
     * @param array $data
     * @return Reminder
     */
    public function createReminder(int $userId, array $data): Reminder
    {
        $remindAt = Carbon::createFromTimestampUTC($data['remind_at']);
        $eventAt = Carbon::createFromTimestampUTC($data['event_at']);

        return Reminder::query()
            ->create([
                'user_id' => $userId,
                'title' => $data['title'],
                'description' => $data['description'],
                'remind_at' => $remindAt,
                'event_at' => $eventAt,
                'is_reminded' => false
            ]);
    }
}
