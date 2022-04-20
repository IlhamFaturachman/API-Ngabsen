<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class teacher extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function attendance_list(){
        return $this->hasMany(attendance_list::class , 'teacher_id');
    }

    
}
