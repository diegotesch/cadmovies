<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CastAthor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('athor_cast', function (Blueprint $table) {
            $table->integer('cast_id')->unsigned();
            $table->foreign('cast_id')->references('id')->on('casts')->onDelete('cascade');
            $table->integer('athor_id')->unsigned();
            $table->foreign('athor_id')->references('id')->on('athors')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cast_athor');
    }
}
