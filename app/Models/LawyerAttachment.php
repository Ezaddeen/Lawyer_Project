<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LawyerAttachment extends Model
{
    //
    protected $fillable = [
        'lawyer_id',
        'file_name',
        'file_path',
        'category',
        'storage_type',
        'file_blob',
        'uploaded_at'
    ];

    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class);
    }
}
