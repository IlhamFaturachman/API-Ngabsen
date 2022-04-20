<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attendance extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    function user(){
        return $this->belongsTo(User::class , 'user_id');
    }

    function student(){
        return $this->belongsTo(student::class , 'student_id');
    }

    function attendance_list(){
        return $this->belongsTo(attendance_list::class , 'attendance_id');
    }
}
