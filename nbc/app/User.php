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
    protected $fillable = [
        'account_id','name', 'email', 'password','verification','verified','role', 'online', 'avatar', 'background'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // for worker
    public function skills () {
        return $this->hasMany('App\WorkerSkill', 'worker_id', 'id');
    }

    public function socialAcc () {
        return $this->hasOne('App\SocialAccount', 'user_id', 'id');
    }

    public function rate () {
        return $this->hasMany('App\Rate', 'worker_id', 'id');
    }
}
