<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $connection = 'mysql';
    protected $name = 'user_id';

    protected $fillable = [
        'user_id', 'name', 'dept_id', 'email', 'password', 'osi_access', 'osi_role', 'yield_access', 'yield_role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function department() {
        return $this->hasOne('App\Department', 'id');
    }
}
