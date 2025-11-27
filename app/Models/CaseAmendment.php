<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseAmendment extends Model
{
    //
    protected $table = 'case_amendments';
    protected $fillable = [
        'case_id',
        'file_name',
        'old_value',
        'new_value',
        'modified_by',
        'modified_at',
    ];
    public function case()
    {
        return $this->belongsTo(Legalcase::class, 'case_id');
    }
    public function modifier()
    {
        return $this->belongsTo(User::class, 'modified_by');
    }
}
