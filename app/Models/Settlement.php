<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $table = 'settlements';

    protected $fillable = ['userid', 'settlement_name'];

    public function user()
    {
        return $this->belongsTo('App\Models\Users', 'user_id', 'id');
    }
}
