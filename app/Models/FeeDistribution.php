<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeDistribution extends Model
{
    protected $fillable = [
        'transaction_id',
        'beneficiary_type',
        'beneficiary_id',
        'rule_type',
        'percentage',
        'amount',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
