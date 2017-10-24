<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlunosPaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alunos_pais', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_aluno')->unsigned();
            $table->foreign('id_aluno')->references('id')->on('alunos');
            $table->integer('id_pai')->unsigned();
            $table->foreign('id_pai')->references('id')->on('pais');
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
        Schema::drop('alunos_pais');
    }
}
