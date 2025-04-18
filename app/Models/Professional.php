<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professional extends Model
{
    use HasFactory;
    public $timestamps=false;

    public function user()
    {
        return $this->belongsTo('App\Models\Users', 'user_id', 'id');
    }
}
