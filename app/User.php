<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function store()
    {
        return $this->hasOne(Store::class);
    }

    public function userinfo()
    {
        return $this->hasOne(Userinfo::class);
    }
    public function article()
    {
        return $this->hasMany(Article::class);
    }





    public function hasRole($role)
    {
        if(is_string($role)){
            return $this->roles->contains('role', $role);
        }
        return !! $role->intersect($this->roles)->count();
    }







}
