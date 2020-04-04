<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    CONST ADMIN = 1;
    CONST SUPER_ADMIN = 2;
    CONST ACTIVATED = 1;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'role'
    ];

    //---------------
    //custom check username and password in Password Grant
    public function findForPassport($username)
    {
        return $this->where('name', $username)->first();
    }
    public function validateForPassportPasswordGrant($password)
    {
        return Hash::check($password, $this->password);
    }
    //----------------
}
