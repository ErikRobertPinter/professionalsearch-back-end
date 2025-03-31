<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Users extends Authenticatable
{
    
    use HasFactory, Notifiable, HasApiTokens;
    public $timestamps=true;
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'surname',
        'firstname',
        'email',
        'phoneNumber',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function roles()
    {
        return $this->hasMany('App\Models\UserRoleMap', 'user_id', 'id');
    }

    public function assignRole($role)
    {
        return $this->roles()->attach($role);
    }

    public function removeRole($role)
    {
        return $this->roles()->detach($role);
    }
    public function hasRole($name)
    {
        foreach($this->roles as $roleMap)
        {
            $nameParts = explode('|', $name);
            if (!empty($nameParts)) {
                foreach ($nameParts as $nameItem) {
                    if (strtolower($roleMap->role->role_name) == strtolower($nameItem)) return true;
                }
            }
        }

        return false;
    }


    //connecting to Profession model
    public function professionals()
    {
        return $this->hasMany('App\Models\Profession', 'user_id', 'id');
    }

    public function assignProfessional($professional)
    {
        return $this->professionals()->attach($professional);
    }

    public function removeProfessional($professional)
    {
        return $this->professionals()->detach($professional);
    }
    
    
    //connecting to Settlement model
    public function settlements()
    {
        return $this->hasMany('App\Models\Settlement', 'user_id', 'id');
    }

    public function assignSettlement($settlement)
    {
        return $this->settlements()->attach($settlement);
    }

    public function removeSettlement($settlement)
    {
        return $this->settlements()->detach($settlement);
    }
}
