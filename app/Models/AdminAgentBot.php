<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminAgentBot extends Model
{
    //
    protected $fillable = [
        'admin_user_id',
        'task',
        'result',
    ];

    public function adminUser()
    {
        return $this->belongsTo(User::class, 'admin_user_id');
    }
}
