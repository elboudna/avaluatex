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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('receveur');
            $table->integer('but_receveur')->default(0);
            $table->integer('but_receveur_mi_temps')->default(0);
            $table->string('couleur_receveur')->nullable();
            $table->string('visiteur');
            $table->integer('but_visiteur')->default(0);
            $table->integer('but_visiteur_mi_temps')->default(0);
            $table->string('couleur_visiteur')->nullable();
            $table->string('duree');
            $table->string('AC');
            $table->string('AA1')->nullable();
            $table->string('AA2')->nullable();
            $table->string('A4')->nullable();
            $table->date('date');
            $table->dateTime('debut_chrono')->nullable();
            $table->dateTime('mitemps_chrono')->nullable();
            $table->string('timeline')->nullable();
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
        Schema::dropIfExists('matchs');
    }
};
