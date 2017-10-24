<?php

namespace App\Models\Painel;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    protected $guarded = ['id'];


    static $rules = [
        'nome'              => 'required|min:3|max:60',
        'telefone'          => 'required|min:14|max:14',
        'data_nascimento'   => 'required',
        'id_turma'          => 'required',
    ];
    
    public function getDataNascimentoAttribute($dataNascimento){
        return \Carbon\Carbon::parse($dataNascimento)->format('d/m/Y');
    }
    
    public function getPais(){
        return $this->belongsToMany('App\Models\Painel\Pai', 'alunos_pais', 'id_aluno', 'id_pai');
    }
}
