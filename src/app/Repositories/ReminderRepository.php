<?php

namespace App\Repositories;
use App\Models\Reminder;
use Carbon\Carbon;

class ReminderRepository
{
    protected $reminder;

    public function __construct(Reminder $reminder)
    {
        $this->reminder = $reminder;
    }

    public function getLimit(int $limit = 10)
    {
        $results = $this->reminder::limit($limit)->orderBy('remind_at', 'ASC')->get();

        return $results;
    }

    public function dataMustSend()
    {
        $now = Carbon::now()->timestamp;

        $results = $this->reminder::where(function($q) use ($now) {
            $q->where('event_at', '<=' , $now)
              ->orWhere('remind_at','<=', $now);
        })
        ->where('status', 0)
        ->get();

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

    public function update($data)
    {
        $getReminder = $this->reminder::findOrFail($data->id);
        $getReminder->update([
            'title' => $data->title,
            'description' => $data->description,
            'remind_at' => $data->remind_at,
            'event_at' => $data->event_at,
        ]);

        return $getReminder;
    }

    public function updateStatusDone($id)
    {
        $getReminder = $this->reminder::findOrFail($id);
        $getReminder->update([
            'status' => 1
        ]);

        return $getReminder;
    }

    public function delete(int $id)
    {
        $getReminder = $this->reminder::findOrFail($id);

        $getReminder->delete();

        return;
    }

}
