<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Http\Controllers\StandardController;
use Illuminate\Validation\Factory;
use App\Models\Painel\Turma;

class TurmaController extends StandardController
{
    protected $request;
    protected $model;
    protected $validator;
    protected $nameView = 'turmas';
    protected $titulo = 'Turmas';


    public function __construct(Request $request, Turma $turma, Factory $validator) 
    {
        $this->request      = $request;
        $this->model        = $turma;
        $this->validator    = $validator;
    }

    public function index()
    {
        $data = $this->model->paginate($this->totalItensPorPagina);
        
        $titulo = $this->titulo;
        
        return view("painel.{$this->nameView}.index", compact('data', 'titulo'));
    }

    public function store()
    {
        $dadosForm = $this->request->all();
        
        $validator = $this->validator->make($dadosForm, Turma::$rules);

        if($validator->fails()){
            $messages = $validator->messages();
            
            $displayErrors = '';
            
            foreach($messages->all("<p>:message</p>") as $error){
                $displayErrors .= $error;
            }
            
            return $displayErrors;
        }

        Turma::create($dadosForm);
        
        return 1;
    }

    public function show($id)
    {
        return $this->model->find($id)->toJson();
    }
    
    public function update($id)
    {
        $dadosForm = $this->request->all();
        
        $validator = $this->validator->make($dadosForm, Turma::$rules);

        if($validator->fails()){
            $messages = $validator->messages();
            
            $displayErrors = '';
            
            foreach($messages->all("<p>:message</p>") as $error){
                $displayErrors .= $error;
            }
            
            return $displayErrors;
        }

        $this->model->find($id)->update($dadosForm);
        
        return 1;
    }

    public function destroy($id)
    {
        $this->model->find($id)->delete();
        return 1;
    }
}