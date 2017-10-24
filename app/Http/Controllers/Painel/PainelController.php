<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;

use App\Models\Painel\Aluno;
use App\Models\Painel\Matricula;
use App\Models\Painel\Pai;
use App\Models\Painel\Turma;

class PainelController extends Controller
{
    
    public function Index(){
        $alunos = Aluno::all()->count();
        $matriculas = Matricula::all()->count();
        $pais = Pai::all()->count();
        $turmas = Turma::all()->count();
        
        return view('painel.home.index', compact('alunos', 'matriculas', 'pais', 'turmas'));
    }
    
    public function missingMethod($parameters = array()) {
        return view('painel.404.index');
    }
}