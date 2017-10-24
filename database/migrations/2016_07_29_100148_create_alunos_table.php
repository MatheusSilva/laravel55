<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlunosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alunos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_turma')->unsigned();
            $table->foreign('id_turma')->references('id')->on('turmas');
            $table->string('nome', 60);
            $table->string('imagem', 200);
            $table->string('telefone', 15);
            $table->date('data_nascimento');
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
        Schema::drop('alunos');
    }
}
