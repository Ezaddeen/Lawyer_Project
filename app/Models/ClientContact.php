<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientContact extends Model
{
    //
    protected $fillable = ['client_id', 'type', 'value'];
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
