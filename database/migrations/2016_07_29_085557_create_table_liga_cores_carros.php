<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableLigaCoresCarros extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('cores_carros', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('id_carro')->unsigned();
            $table->foreign('id_carro')->references('id')->on('carros');
            $table->integer('id_cor')->unsigned();
            $table->foreign('id_cor')->references('id')->on('cores');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('cores_carros');
    }

}
