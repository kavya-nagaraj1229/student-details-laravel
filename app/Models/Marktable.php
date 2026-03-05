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

    public function user()
    {
        return $this->belongsTo(User::class,'student_id','student_id');
    }
}