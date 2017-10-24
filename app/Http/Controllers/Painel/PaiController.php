<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Http\Controllers\StandardController;
use Illuminate\Validation\Factory;
use App\Models\Painel\Pai;

class PaiController extends StandardController
{
    protected $totalItensPorPagina = 10;

    protected $request;
    protected $model;
    protected $validator;
    protected $nameView = 'pais';
    protected $titulo = 'Pais';


    public function __construct(Request $request, Pai $pai, Factory $validator) 
    {
        $this->request      = $request;
        $this->model        = $pai;
        $this->validator    = $validator;
    }
    
    
    public function index()
    {
        $pais = $this->model->paginate($this->totalItensPorPagina);
        
        $titulo = $this->titulo;
        
        return view("painel.{$this->nameView}.index", compact('pais', 'titulo'));
    }

    public function store()
    {
        $dadosForm = $this->request->all();

        $validator = $this->validator->make($dadosForm, Pai::$rules);
        if($validator->fails()){
            $messages = $validator->messages();
            
            $displayErrors = '';
            
            foreach($messages->all("<p>:message</p>") as $error){
                $displayErrors .= $error;
            }
            
            return $displayErrors;
        }

        Pai::create($dadosForm);
        
        return 1;
    }

    public function destroy($id)
    {
        $pais = $this->model->find($id);
        $pais->delete();
        
        return 1;
    }

    public function pesquisarPais($palavraPesquisa)
    {
        $pais = $this->model->getPais($palavraPesquisa, $this->totalItensPorPagina);
        
        return view('painel.pais.lista', compact('pais', 'palavraPesquisa'));
    }
}