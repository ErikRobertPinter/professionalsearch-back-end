<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRoleMap extends Model
{
    use HasFactory;
    protected $table = 'user_role_maps';

    protected $casts = [
        
    ];

    public $timestamps = false;

    public function role()
    {
        return $this->belongsTo('App\Models\UserRole', 'user_role_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\Users');
    }
}
