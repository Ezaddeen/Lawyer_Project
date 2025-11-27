<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LawyerContact extends Model
{
    //
    protected $fillable = [
        'lawyer_id',
        'type',
        'value',
    ];

    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class);
    }
}
