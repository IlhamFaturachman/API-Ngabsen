<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ClassData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('majors' , function(Blueprint $table){
            $table->id();
            $table->string('name');
        });

        Schema::create('classes' , function(Blueprint $table){
            $table->id();
            $table->enum('grade' , ['X' , 'XI' , 'XII' , 'XIII']);
            $table->foreignId('major_id')->constrained('majors')->onUpdate('cascade')->onDelete('cascade');
            $table->string('class');
        });

        Schema::table('attendance_lists' , function(Blueprint $table){
            $table->dropColumn('class');
            $table->foreignId('class_id')->constrained('classes')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendance_lists' , function(Blueprint $table){
            $table->string('classs');
            $table->dropForeign('class');
        });

        Schema::dropIfExists('classes');

        Schema::dropIfExists('majors');
    }
}
