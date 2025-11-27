<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workflow extends Model
{
    //
    protected $fillable = [
        'name',
        'module',
        'related_case_id',
        'state',
        'step_no',
        'step_desc',
        'assigned_user_id',
        'start_at',
        'end_at',
        'notes',
    ];

    public function relatedCase()
    {
        return $this->belongsTo(Legalcase::class, 'related_case_id');
    }
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }
}
