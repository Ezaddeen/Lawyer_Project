<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LawsDocument extends Model
{
    //
    protected $table = 'laws_documents';
    protected $fillable = [
        'law_number',
        'law_title',
        'law_description',
        'issue_date',
        'amendment_date',
        'law_category',
    ];
    
    public function logalAssistantBots()
    {
        return $this->hasMany(LogalAssistantBot::class, 'source_law_id');
    }
}

