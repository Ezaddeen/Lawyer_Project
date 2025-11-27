<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //
    protected $fillable = [
        'name',
        'type',
        'city',
        'address',
        'email',
        'phone',
        'username',
        'password',
        'start_at',
        'end_at',
        'note',
    ];
    public function contacts()
    {
        return $this->hasMany(ClientContact::class);
    }
    public function cases()
    {
        return $this->hasMany(Legalcase::class);
    }
    public function hearings()
    {
        return $this->hasMany(Hearing::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function documents()
    {
        return $this->hasMany(Document::class, 'client_id');
    }
    public function authorizations()
    {
        return $this->hasMany(Authorization::class);
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    
}
