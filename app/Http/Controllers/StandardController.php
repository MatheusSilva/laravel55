<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class StandardController extends BaseController
{
    use DispatchesJobs, ValidatesRequests;
    
    protected $totalItensPorPagina = 10;
    
    
    public function index(){
        $data = $this->model->paginate($this->totalItensPorPagina);
        
        $titulo = $this->titulo;
        
        return view("painel.{$this->nameView}.index", compact('data', 'titulo'));
    }
    
    public function postAdicionar(){
        $dadosForm = $this->request->all();
        
        $validator = $this->validator->make($dadosForm, $this->model->rules);
        if($validator->fails()){
            $messages = $validator->messages();
            
            $displayErrors = '';
            
            foreach($messages->all("<p>:message</p>") as $error){
                $displayErrors .= $error;
            }
            
            return $displayErrors;
        }
        
        $this->model->create($dadosForm);
        
        return 1;
    }
    
    public function getEditar($id){
        return $this->model->find($id)->toJson();
    }
    
    
    public function postEditar($id){
        $dadosForm = $this->request->all();
        
        $validator = $this->validator->make($dadosForm, $this->model->rules);
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
    
    public function getDeletar($id){
        $this->model->find($id)->delete();
        
        return 1;
    }
}