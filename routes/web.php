<?php

//curl -X POST "Accept: application/x-www-form-urlencoded; charset=UTF-8" -F "nome=99" -F  "_token=eb91NqLjklMfOKDe58EPAwk7hbz0lt5lrgaKpIKr"    "http://127.0.0.1/painel/turmas/5"

/*
Route::get('/', function () {
    return view('welcome');
});
*/

//header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS');

Route::group(['prefix' => 'painel', 'middleware' => 'auth'], function(){
    Route::resource('alunos', 'Painel\AlunoController');

    Route::get('alunos/pesquisar-pais/{id}/{palavraPesquisa}', 'Painel\AlunoController@pesquisarPais');

    Route::get('alunos/pesquisar/{palavraPesquisa}', 'Painel\AlunoController@pesquisar');
    Route::get('alunos/pais/{id}', 'Painel\AlunoController@pais');

    Route::delete('alunos/deletar-pai/{idAluno}/{idPai}', 'Painel\AlunoController@deletarPai'); //não testado
    Route::get('alunos/adicionar-pai/{idAluno}', 'Painel\AlunoController@adicionarPai');

    Route::get('pais/pesquisar-pais/{palavraPesquisa}', 'Painel\PaiController@pesquisarPais');

    Route::resource('turmas', 'Painel\TurmaController');
    Route::resource('pais', 'Painel\PaiController');
    Route::resource('carros', 'Painel\CarrosController');
    

    Route::resource('/', 'Painel\PainelController');
});


// Authentication routes...

Route::get('login', 'Auth\LoginController@login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout');

// Registration routes...
//Route::get('auth/register', 'Auth\LoginController@getRegister');
//Route::post('auth/register', 'Auth\LoginController@postRegister');

// Password reset link request routes...
//Route::get('recuperar-senha', 'Auth\PasswordController@getEmail');
Route::post('password/reset', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset/', 'Auth\PasswordController@postReset');

Route::resource('carros', 'CarrosController');

/*
Tenho colocar algumas rotas manualemente pois o Html::link só suporta get 
e Html::form só POST ao inves de utilizar apenas o Route::resource com restFull 
*/

Route::get('users/adicionar', 'UserController@criar');
Route::post('users/adicionar', 'UserController@adicionar');
Route::post('users/atualizar/{id}', 'UserController@atualizar');
Route::get('users/deletar/{id}', 'UserController@deletar');
Route::resource('users', 'UserController');

Route::get('sessao/gravar', function(){
	echo "GRAVAR: Gravando sessão";
	session(['msg'=>'Gravando sessão no Laravel!']);
});

Route::get('sessao/exibir', function(){
	$msg = session('msg');
	return $msg;
});

Route::resource('collection', 'CollectionController');

Route::get('email', function(){
	Mail::raw('Mensagem de testo puro', function ($m) {
    	 $m->to('querotestar.isso@yahoo.com.br','João')->subject('Enviando E-mails pelo Laravel');
	});
});

Route::auth();

Route::get('/home', 'HomeController@index');
Route::resource('/', 'Site\HomeController');
Auth::routes();

Route::get('/home', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index');
