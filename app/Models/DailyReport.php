<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyReport extends Model
{
    protected $fillable = [
        'case_id',
        'lawyer_id',
        'report_date',
        'content',
        'week_no',
        'status',
        'reviewer_id',
    ];

    public function case()
    {
        return $this->belongsTo(Legalcase::class, 'case_id');
    }
   //ُEditing  add this function 
    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class, 'lawyer_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
