<?php

namespace App\Services;

use App\Models\Reminder;
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
}
