<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marktable extends Model
{
    protected $table = 'marktables';

    protected $fillable = [
        'student_id', 
        'name',
        'class',
        'session',
        'age',
        'subjectsmark',
        'total',
        'average',
        'images'
    ];

    public $timestamps = false;
}