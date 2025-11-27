<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogalAssistantBot extends Model
{
    //
    protected $fillable = [
        'user_id',
        'question',
        'response',
        'source_law_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function sourceLaw()
    {
        return $this->belongsTo(LawsDocument::class, 'source_law_id');
    }
}
