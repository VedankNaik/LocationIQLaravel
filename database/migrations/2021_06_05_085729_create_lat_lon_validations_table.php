<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLatLonValidationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lat_lon_validations', function (Blueprint $table) {
            $table->increments('ID');
            $table->integer('RefID');   
            $table->string('City')->nullable();   
            $table->double('OldLatitude')->nullable();   
            $table->double('OldLongitude')->nullable();   
            $table->integer('PlaceID')->nullable();   
            $table->double('NewLatitude')->nullable();   
            $table->double('NewLongitude')->nullable();   
            $table->string('DisplayName')->nullable();   
            $table->double('Importance')->nullable();   ;    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lat_lon_validations');
    }
}
