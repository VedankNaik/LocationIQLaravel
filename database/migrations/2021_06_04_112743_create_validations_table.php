<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValidationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('validations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('EGID')->nullable();   
            $table->string('Street')->nullable();   
            $table->integer('Zip')->nullable();   
            $table->string('Town')->nullable();   
            $table->integer('PlaceID')->nullable();   
            $table->double('Latitide')->nullable();   
            $table->double('Longitude')->nullable();   
            $table->string('DisplayName')->nullable();   
            $table->string('Class')->nullable();   
            $table->string('Type')->nullable();   
            $table->double('Importance')->nullable();                 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('validations');
    }
}
