<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
    use HasFactory;
    public $timestamps=true;
    protected $table = 'professions';

    protected $fillable = [
        'user_id',
        'profession_name',
        'school',
        'description'
    ];
}
