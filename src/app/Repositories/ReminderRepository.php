<?php

namespace App\Repositories;
use App\Models\Reminder;

class ReminderRepository
{
    protected $reminder;

    public function __construct(Reminder $reminder)
    {
        $this->reminder = $reminder;
    }

    public function getLimit(int $limit = 10)
    {
        $results = $this->reminder::limit($limit)->get();

        return $results;
    }

    public function save($data, int $userId)
    {
        $results = $this->reminder::create([
            'title' => $data->title,
            'description' => $data->description,
            'remind_at' => $data->remind_at,
            'event_at' => $data->event_at,
            'created_by' => $userId,
        ]);

        return $results;
    }

    public function getDetail(int $id)
    {
        $results = $this->reminder::find($id);

        return $results;
    }

    public function update($data, int $id)
    {
        $getReminder = $this->reminder::findOrFail($id);

        $getReminder->update([
            'title' => $data->title,
            'description' => $data->description,
            'remind_at' => $data->remind_at,
            'event_at' => $data->event_at,
        ]);

        return $getReminder;
    }

    public function delete(int $id)
    {
        $getReminder = $this->reminder::findOrFail($id);

        return $getReminder->delete();
    }

}
