<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RevenueDistributionRule extends Model
{
    //
    protected $fillable = [
        'lawyer_id',
        'case_id',
        'type',
        'percentage',
        'amount',
        'effective_from',
        'effective_to',
    ];

    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class);
    }
    public function case()
    {
        return $this->belongsTo(Legalcase::class, 'case_id');
    }
}
