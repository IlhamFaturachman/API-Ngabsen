<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Attendance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances' , function (Blueprint $table){
            $table->id();
            $table->foreignId('user_id')->constrained('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('attendance_id')->constrained('attendance_lists')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->dateTime('attendance_time');
            $table->enum('status' , ['onTime' , 'late']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
