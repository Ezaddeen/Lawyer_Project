<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
    //
    protected $fillable = [
        'name',
        'kind',
        'level',
        'city',
        'address',
        'location',
        'notes',
    ];
    public function changes()
    {
        return $this->hasMany(CourtChange::class);
    }
    public function cases()
    {
        return $this->hasMany(Legalcase::class);
    }
    public function hearings()
    {
        return $this->hasMany(Hearing::class);
    }
}
