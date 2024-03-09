<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_evenements', function (Blueprint $table) {
            $table->id();
            $table->integer('position_x');
            $table->integer('position_y');
            $table->string('image_url');
            $table->integer('numero_evenement');
            $table->unsignedBigInteger('evenement_id');
            $table->unsignedBigInteger('game_id');
            $table->foreign('evenement_id')->references('id')->on('evenements')->onDelete('cascade');
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
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
        Schema::dropIfExists('image_evenement');
    }
};
