<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class classes extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    function major(){
        return $this->belongsTo(major::class , 'major_id');
    }
}
