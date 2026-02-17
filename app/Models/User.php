<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';

    protected $fillable = ['username','password','role','student_id'];

    protected $hidden = ['password'];

    // remove mutator to avoid double bcrypt
    // public function setPasswordAttribute($value){
    //     $this->attributes['password'] = bcrypt($value);
    // }
}
