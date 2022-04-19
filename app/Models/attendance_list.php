<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class attendance_list extends Authenticatable
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    function teacher(){
        return $this->belongsTo(teacher::class , 'teacher_id');
    }
}
