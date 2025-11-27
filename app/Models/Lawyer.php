<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lawyer extends Model
{
    //
    protected $fillable = [
        'name',
        'grade',
        'city',
        'address',
        'email',
        'username',
        'password',
        'phone',
        'joined_at',
        'end_at',
        'note'
    ];
    public function contacts()
    {
        return $this->hasMany(LawyerContact::class);
    }

    public function attachments()
    {
        return $this->hasMany(LawyerAttachment::class);
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
        return $this->hasMany(Document::class);
    }
    public function authorizations()
    {
        return $this->hasMany(Authorization::class);
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    public function revenueDistributionRules()
    {
        return $this->hasMany(RevenueDistributionRule::class, 'lawyer_id');
    }

}
