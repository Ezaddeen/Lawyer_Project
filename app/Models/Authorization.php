<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Authorization extends Model
{
    protected $fillable = [
        'client_id',
        'lawyer_id',
        'type',
        'company_name',
        'year',
        'start_date',
        'end_date',
        'office_file_no',
        'attachments',
        'notes',
    ];

    protected $casts = [
        'attachments' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'year' => 'date:Y',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class);
    }
}
