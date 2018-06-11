<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\Controller;
use App\Models\Painel\Aluno;
use App\Models\Painel\Turma;
use App\Models\Painel\Matricula;
use Illuminate\Validation\Factory;

class AlunoController extends Controller
{
    private $totalItensPorPagina = 10;
    
    private $request;
    private $aluno;
    private $validator;
    
    public function __construct(Request $request, Aluno $aluno, Factory $validator) 
    {
        $this->request      = $request;
        $this->aluno        = $aluno;
        $this->validator    = $validator;
    }
    
    public function index()
    {
        //$alunos = $this->aluno->paginate($this->totalItensPorPagina);
        $alunos = $this->aluno
                    ->join('matriculas', 'matriculas.id_aluno', '=', 'alunos.id')
                    ->join('turmas', 'turmas.id', '=', 'alunos.id_turma')
                    ->select('matriculas.numero as matricula', 'alunos.nome', 'alunos.telefone', 'alunos.data_nascimento', 'alunos.id', 'turmas.nome as turma')
                    ->paginate($this->totalItensPorPagina);
        
        $turmas = Turma::pluck('nome', 'id');
        
        $titulo = 'Alunos';
        
        return view('painel.alunos.index', compact('alunos', 'turmas', 'titulo'));
    }

    public function store()
    {
        $dadosForm = $this->request->all();
        

        $validator = $this->validator->make($dadosForm, Aluno::$rules);
        if($validator->fails()){
            $messages = $validator->messages();
            
            $displayErrors = '';
            
            foreach($messages->all("<p>:message</p>") as $error){
                $displayErrors .= $error;
            }
            
            return $displayErrors;
        }
        $dadosForm['data_nascimento'] = \Carbon\Carbon::createFromFormat('d/m/Y', $dadosForm['data_nascimento'])->toDateString();
        

        $aluno = $this->aluno->create($dadosForm);
        $matricula = ['id_aluno' => $aluno->id, 'numero' => uniqid($aluno->id)];
        Matricula::create($matricula);
        
        return 1;
    }
    
    public function show($id)
    {
        return $this->aluno->find($id)->toJson();
    }
    
    
    public function update($id)
    {
        $dadosForm = $this->request->all();
        
        $validator = $this->validator->make($dadosForm, Aluno::$rules);
        if($validator->fails()){
            $messages = $validator->messages();
            
            $displayErrors = '';
            
            foreach($messages->all("<p>:message</p>") as $error){
                $displayErrors .= $error;
            }
            
            return $displayErrors;
        }
        $dadosForm['data_nascimento'] = \Carbon\Carbon::createFromFormat('d/m/Y', $dadosForm['data_nascimento'])->toDateString();
        
        $this->aluno->find($id)->update($dadosForm);
        
        return 1;
    }
    
    public function destroy($id)
    {
        $aluno = $this->aluno->find($id);
        $aluno->getPais()->detach();
        $aluno->delete();
        
        return 1;
    }
    
    
    public function pais($id)
    {
        $aluno = $this->aluno->find($id);
        
        $pais = $aluno->getPais()->paginate($this->totalItensPorPagina);
        
        $titulo = "Pais do Aluno: {$aluno->nome}";
        
        $paisAdd = \App\Models\Painel\Pai::pluck('nome', 'id');

        //dd("abc12");exit;
        
        return view('painel.alunos.pais', compact('aluno', 'pais', 'titulo', 'paisAdd', 'id'));
    }
    
    public function adicionarPai($idAluno)
    {
        $idPai = $this->aluno->find($idAluno)->getPais()->sync($this->request->get('id_pai'));

        $alunos = $idAluno;
        
        $id = $idAluno;

        $aluno = $this->aluno->find($id);
        
        $pais = $aluno->getPais()->paginate($this->totalItensPorPagina);
        
        $titulo = "Pais do Aluno: {$aluno->nome}";
        
        $paisAdd = \App\Models\Painel\Pai::pluck('nome', 'id');
        
        return view('painel.alunos.pais', compact('aluno', 'pais', 'titulo', 'paisAdd', 'id'));
    }
    
    public function deletarPai($idAluno, $idPai)
    {
        //dd("adasdasd");exit;
        return $this->aluno->find($idAluno)->getPais()->detach($idPai);
    }
    
 
    public function pesquisar($palavraPesquisa = '')
    {
        $alunos = $this->aluno->where('nome', 'LIKE', "%{$palavraPesquisa}%")->paginate($this->totalItensPorPagina);
        
        $turmas = Turma::pluck('nome', 'id');
        
        $titulo = "Resultados para a pesquisa: {$palavraPesquisa}";
        
        return view('painel.alunos.index', compact('alunos', 'turmas', 'titulo', 'palavraPesquisa'));
    }
    
    public function pesquisarPais($id, $palavraPesquisa)
    {
        $aluno = $this->aluno->find($id);
        
        $pais = $aluno->getPais()->where('nome', 'LIKE', "%$palavraPesquisa%")->paginate($this->totalItensPorPagina);
        
        $titulo = "Resultados para a pesquisa: $palavraPesquisa | Aluno: {$aluno->nome}";
        
        $paisAdd = \App\Models\Painel\Pai::pluck('nome', 'id');
        
        return view('painel.alunos.pais', compact('aluno', 'pais', 'titulo', 'paisAdd', 'id', 'palavraPesquisa'));
    }
}