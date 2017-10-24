<?php

namespace App\Http\Controllers\Painel;

use DB;
use App\Models\Painel\Carro;
use Illuminate\Http\Request;
use Validator;
use Cache;
use App\Models\Painel\MarcasCarro;
use App\Http\Controllers\Controller;

class CarrosController extends Controller 
{
    private $carro;
    private $request;
    private $validator;

    public function __construct(Carro $carro, Request $request, \Illuminate\Validation\Factory $validator) 
    {
        $this->carro = $carro;
        $this->request = $request;
        $this->validator = $validator;
    }

    public function index() 
    {
        $carros = $this->carro->paginate(2);

        $titulo = 'Listagem dos Carros';
        
        //Busca todas as marcas de carros
        $marcas = MarcasCarro::pluck('marca', 'id');

        return view('painel.carros.index', compact('carros', 'titulo', 'marcas'));
    }

    public function getAdicionar() 
    {
        $titulo = 'Adicionar Novo Carro';

        //Busca todas as marcas de carros
        $marcas = Marcas::pluck('marca', 'id')->toJson();

        return view('painel.carros.create-edit', compact('titulo', 'marcas'));
    }

    public function postAdicionar() 
    {
        /*
        $carro = new Carro;
        $carro->nome = $request->input('nome');
        $carro->placa = $request->input('placa');
        $carro->save();
        */
        $dadosForm = $request->except('file');

        $validator = Validator::make($dadosForm, Carro::$rules);

        if( $validator->fails() ){
            return redirect('carros/adicionar')
                        ->withErrors($validator)
                        ->withInput();
        }

        $file = $request->file('file');

        if( $request->hasFile('file') && $file->isValid() ){
            if($file->getClientMimeType() == "image/jpeg" || $file->getClientMimeType() == "image/png"){
                $file->move('assets/uploads/images', $file->getClientOriginalName());
            }
        }

        $carro = Carro::create($dadosForm);

        return redirect("carros/editar/$carro->id");
    }
    
    public function postAdicionarViaAjax() 
    {
        $dadosForm = $this->request->all();

        $validator = $this->validator->make($dadosForm, Carro::$rules);

        if( $validator->fails() ){
            $messages = $validator->messages();
            
            $displayErrors = '';
            foreach($messages->all("<p>:message</p>") as $error){
                $displayErrors .= $error;
            }
            
            return $displayErrors;
        }

        $this->carro->create($dadosForm);

        return 1;
    }
    
    public function getCarrosAjax()
    {
        //sleep(3); //aguarda 3 segundos antes da proxima instrução
        return $this->carro->get()->toJson();
    }

    public function getEditar($idCarro) 
    {
        $carro = $this->carro->find($idCarro);

        //Busca todas as marcas de carros
        $marcas = MarcasCarro::pluck('marca', 'id');

        return view('painel.carros.create-edit', compact('carro', 'marcas'));
    }

    public function postEditar($idCarro) 
    {
        $dadosForm = $this->request->except('_token');

        $rulesEdit = [
            'nome' => 'required|min:3|max:150',
            'placa' => "required|min:7|max:7|unique:carros,placa,$idCarro",
        ];

        $validator = $this->validator->make($dadosForm, $rulesEdit);
        if ($validator->fails()) {
            return redirect("carros/editar/$idCarro")
                            ->withErrors($validator)
                            ->withInput();
        }

        Carro::where('id', $idCarro)->update($dadosForm);

        return redirect('carros');
    }

    public function getDeletar($idCarro) 
    {
        $carro = Carro::find($idCarro);
        $carro->delete();

        return redirect('carros');
    }

    public function getListaCarrosLuxo() 
    {
        return 'Listando os carros de luxo';
    }

    public function missingMethod($params = array()) 
    {
        return 'Erro 404, página não encontrada!';
    }

    public function getListarCarrosCache() 
    {
        // Cache::put('carros', Carro::all() , 3);
        // $carros = Cache::get('carros','Nao existe carros');

        $carros = Cache::remember('carros', 3, function() {
                    return Carro::all();
                });

        return $carros;
    }

}
