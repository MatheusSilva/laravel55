@extends('painel.templates.index')

@section('content')
{!!Html::link('users', 'Voltar', ['class' => 'btn'])!!}
<h1>Gestão do Usuário</h1>

@if( count($errors) > 0 )
<div class="alert alert-warning" role="alert">
    @foreach( $errors->all() as $error )
    {{$error}}<br>
    @endforeach
</div>
@endif

@if( isset($user) )
{!!Form::open( ['url' => "users/atualizar/$user->id", 'files' => true, 'class' => 'form'] )!!}
@else
{!!Form::open( ['url' => 'users/adicionar', 'files' => true, 'class' => 'form'] )!!}
@endif
    {!!Form::text('name', isset($user->name) ? $user->name : null , ['placeholder' => 'Nome do Usuário', 'class' => 'form-control form-group'] )!!}
    {!!Form::text('email', isset($user->email) ? $user->email : null, ['placeholder' => 'E-mail do Usuário', 'class' => 'form-control form-group'] )!!}
    {!!Form::password('password', ['placeholder' => 'Senha do Usuário', 'class' => 'form-control form-group'] )!!}
    {!!Form::submit('Enviar', ['class' => 'btn btn-default form-group'])!!}
    {!!Form::close()!!}
@endsection