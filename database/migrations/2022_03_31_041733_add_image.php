<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students' , function (Blueprint $table){
            $table->string('image')->nullable();
        });

        Schema::table('teachers' , function (Blueprint $table){
            $table->string('image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropColumns('students' , ['image']);
        Schema::dropColumns('teachers' , ['image']);
    }
}
