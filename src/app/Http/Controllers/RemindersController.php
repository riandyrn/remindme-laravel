<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reminder;
use Illuminate\Support\Facades\Validator;

class RemindersController extends Controller
{
    public function create(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'remind_at' => 'required|date',
            'event_at' => 'required|date',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Buat reminder
        $reminder = Reminder::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'remind_at' => $request->input('remind_at'),
            'event_at' => $request->input('event_at'),
        ]);

        // Beri respons sukses
        return response()->json(['message' => 'Reminder created successfully', 'data' => $reminder], 201);
    }
}
