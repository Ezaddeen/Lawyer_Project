<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'priority',
        'status',
        'percent_complete',
        'description',
        'due_date',
        'finished_at',
        'attachments',
        'notes',
    ];

    protected $casts = [
        'attachments' => 'array',
        'due_date' => 'date',
        'finished_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
