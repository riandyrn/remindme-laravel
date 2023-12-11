<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'description',
        'remind_at',
        'event_at',
        'created_by',
    ];
}
