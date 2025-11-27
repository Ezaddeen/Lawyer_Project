<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hearing extends Model
{
    protected $fillable = [
        'case_id',
        'court_id',
        'lawyer_id',
        'client_id',
        'hearing_datetime',
        'topic',
        'decision',
        'required_action',
        'postponed_to',
        'conter',
        'notes',
        'calendar_tag',
    ];

    public function case()
    {
        return $this->belongsTo(Legalcase::class, 'case_id');
    }
    public function court()
    {
        return $this->belongsTo(Court::class, 'court_id');
    }
    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class, 'lawyer_id');
    }
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}



