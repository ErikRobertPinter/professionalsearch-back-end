<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    public $timestamps=true;
    protected $table = 'jobs';

    protected $fillable = [
        'userid',
        'title',
        'address',
        'customer',
    ];
    public function user()
{
    return $this->belongsTo(User::class, 'user_id'); // ha a meződ 'userId', akkor ezt kell megadni
}
}
