<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BotFeedbak extends Model
{
    //
    protected $fillable = [
        'bot_kind',
        'user_id',
        'rating',
        'comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
