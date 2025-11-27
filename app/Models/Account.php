<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'account_name',
        'account_type',
        'currency',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // دالة لحساب الرصيد
    public function getBalanceAttribute()
    {
        $income = $this->transactions()->where('txn_type', 'income')->sum('amount');
        $expense = $this->transactions()->where('txn_type', 'expense')->sum('amount');

        return $income - $expense;
    }
}
