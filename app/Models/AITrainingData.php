<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AITrainingData extends Model
{
    //
    protected $table = 'a_i_training_data';
    protected $fillable = ['id', 'name', 'description', 'created_at', 'updated_at'];
}
