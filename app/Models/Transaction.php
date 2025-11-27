<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    
    protected $fillable = [
        'account_id',
        'client_id',
        'lawyer_id',
        'case_id',
        'transaction_category_id',
        'amount',
        'txn_type',
        'txn_date',
        'notes',
    ];
    
    public function account()
    {
        return $this->belongsTo(Account::class);
    }
    
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    
    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class); 
    }
    
    public function case()
    {
        return $this->belongsTo(Legalcase::class);
    }
    
    public function transaction_category()
    {
        return $this->belongsTo(TransactionCategorie::class);
    }
    public function fee_distributions()
    {
        return $this->hasMany(FeeDistribution::class);
    }
} 
