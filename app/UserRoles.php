<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserRoles extends Authenticatable
{
    use Notifiable;
    protected $table = "tbl_user_roles";

    /**
     * The attributes that should be say the guard name.
     *
     * @var array
     */
    protected $guard = 'admin';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','parent_role','level','status','permission','action_permission',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
