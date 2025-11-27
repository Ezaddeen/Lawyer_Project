<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'case_id',
        'client_id',
        'lawyer_id',
        'name',
        'doc_type',
        'storage_type',
        'file_path',
        'file_blob',
        'upload_at',
        'notes',
        'is_missing',
        'in_trash', 
    ];

    protected $casts = [
        'in_trash' => 'boolean',
        'is_missing' => 'boolean',
    ];

    public function legalCase()
    {
        return $this->belongsTo(Legalcase::class, 'case_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class, 'lawyer_id');
    }
}
