<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;
    protected $table = 'user_roles';

    protected $casts = [
        
    ];

    public $timestamps = false;

    public function roles()
    {
        return $this->hasMany('App\Models\UserRoleMap', 'user_role_id', 'id');
    }

    public function assignRole($role)
    {
        return $this->roles()->attach($role);
    }
}
