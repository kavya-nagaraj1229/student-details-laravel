<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use Notifiable;

     protected $table = 'students'; 

protected $fillable = [
'name',
'lastname',
'fathername',
'mothername',
'gender',
'maritalstatus',
'spouse',
'bloodgroup',
'education',
'contact_number',
'aadhar',
'pan',
'license',
'pf_number',
'uan_number',
'esi_number',
'contact_address',
'contact_pincode',
'permanent_address',
'permanent_pincode',
'email',
'password',
'age',
'dob',
'role',
'files'
];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'files' => 'array',
    ];

    

    public $timestamps = false; 
}
