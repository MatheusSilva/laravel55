<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Validator;
use Crypt;
use Hash;
use Mail;

class UserController extends Controller {

    private $request;
    private $user;

    public function __construct(Request $request, User $user) {
        $this->request = $request;
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $titulo = 'Usuários | Curso de Laravel 5';
        $users  = User::paginate(5);
        $status = "";

       if ($this->request->session()->has('status')) 
       {
            $status = $this->request->session()->get('status');
        }

        return view('painel.users.index', ['users' => $users, 'titulo' => $titulo, 'status'=> $status]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function criar() 
    {
        return view('painel.users.create-edit');
    }

    public function adicionar() {
        $dadosForm = $this->request->all();

        $validator = Validator::make($dadosForm, User::$rules);
        if ($validator->fails()) {
            return redirect('users/adicionar')
                            ->withErrors($validator)
                            ->withInput();
        }

        $dadosForm['password'] = Hash::make($dadosForm['password']);

        $this->user->create($dadosForm)->save();

        $status = "Usuário ".$dadosForm['name']. " foi criado com sucesso!";

        $this->request->session()->flash('status',$status);

        $this->disparaEmailFila($dadosForm['name']);

        return redirect('users');
    }

    public function deletar($idUser) {
        $this->user->find($idUser)->delete();

        return redirect('users');
    }

    public function show($id) 
    {
        $user = $this->user->find($id);

        $titulo = "Editar {$user->name} | Gestão do Usuário";

        return view('painel.users.create-edit', ['user' => $user, 'titulo' => $titulo]);
    }

    public function atualizar($id) {
        $dadosForm = $this->request->all();
        unset($dadosForm['_method']);
        //dd($dadosForm);exit;

        $rules = [
            'name' => 'required|min:3|max:150',
            'email' => "required|email|max:250|unique:users,email,$id",
            'password' => 'required|min:3|max:20',
        ];
        $validador = Validator::make($dadosForm, $rules);
        if( $validador->fails() ){
            return redirect("users/$id")
                            ->withErrors($validador)
                            ->withInput();
        }
        $dadosForm = $this->request->except('_token');
        //$dadosForm['password'] = Hash::make($dadosForm['password']);
        $dadosForm['password'] = bcrypt($dadosForm['password']);

        $this->user->where('id',$id)->update($dadosForm);
        
        return redirect('users');
    }

    private function disparaEmail($nome)
    {

        Mail::send('emails.novousuario', ['nome' => $nome], function ($m) {
            $m->to('querotestar.isso@yahoo.com.br', 'Fulano')
                ->subject('Novo usuário Cadastrado');
        });

        /*
        Mail::send('emails.novousuario', ['nome' => $nome], function ($m) {
            $m->to('querotestar.isso@yahoo.com.br', 'Fulano')
                ->subject('Novo usuário Cadastrado')
                ->attach("http://www.systeach.com.br/assets/portal/imgs/logo.png");;
        });
        */
    }

    private function disparaEmailFila($nome)
    {

        /*
        Mail::queue('emails.novousuario', ['nome' => $nome], function ($m) {
            $m->to('querotestar.isso@yahoo.com.br', 'Fulano')
                ->subject('Novo usuário Cadastrado');
        });
        */

        /*
        Mail::queue('emails.novousuario', ['nome' => $nome], function ($m) {
            $m->to('querotestar.isso@yahoo.com.br', 'Fulano')
                ->subject('Novo usuário Cadastrado')
                ->attach("http://www.systeach.com.br/assets/portal/imgs/logo.png");;
        });
        */
    }

}
