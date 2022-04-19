<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class QrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_lists' , function (Blueprint $table){
            $table->id();
            $table->foreignId('teacher_id')->constrained('teachers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('subject_id')->constrained('subjects')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('qr_value');
            $table->string('class');
            $table->date('date');
            $table->dateTime('open_time');
            $table->dateTime('closed_time');
            $table->enum('status' , ['available' , 'unavailable']);
            $table->string('description');
            $table->string('image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance_lists');
    }
}
