<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourtChange extends Model
{
    //
    protected $fillable = [
        'court_id',
        'old_location',
        'new_location',
        'modifed_by',
        'change_date',
    ];

    public function court()
    {
        return $this->belongsTo(Court::class);
    }
    public function modifier()
    {
        return $this->belongsTo(User::class, 'modifed_by');
    }
}
