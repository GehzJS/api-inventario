<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    
    protected $fillable = [
        'username', 'email', 'password', 'role', 'api_token'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function inputs()
    {
        return $this->hasMany(Input::class);
    }
}
