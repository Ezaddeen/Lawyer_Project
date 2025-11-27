<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Legalcase extends Model
{
    //
    protected $table = 'legal_case';
    protected $fillable = [
        'case_number',
        'client_id',
        'lawyer_id',
        'court_id',
        'client_role',
        'title',
        'category',
        'status',
        'received_at',
        'ended_at',
        'office_file_no',
        'note',
    ];
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class, 'lawyer_id');
    }
    public function court()
    {
        return $this->belongsTo(Court::class);  
    }
    public function amendments()
    {
        return $this->hasMany(CaseAmendment::class, 'case_id');
    }
    public function hearings()
    {
        return $this->hasMany(Hearing::class, 'case_id');
    }
    public function documents()
    {
        return $this->hasMany(Document::class, 'case_id');
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'case_id');
    }
    public function revenueDistributionRules()
    {
        return $this->hasMany(RevenueDistributionRule::class, 'case_id');
    }
    public function dailyReports()
    {
        return $this->hasMany(DailyReport::class, 'case_id');
    }
    public function workflows()
    {
        return $this->hasMany(Workflow::class, 'related_case_id');
    }
}
