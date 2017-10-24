@extends('painel.templates.index')

@section('content')
<h1>Gestão do Carro</h1>

@if( count($errors) > 0 )
<div class="alert alert-warning" role="alert">
    @foreach( $errors->all() as $error )
    {{$error}}
    @endforeach
</div>
@endif

@if( isset($carro) )
	{!!Form::open( ['url' => "carros/editar/$carro->id", 'files' => true, 'class' => 'form'] )!!}
@else
	{!!Form::open( ['url' => 'carros/adicionar', 'files' => true, 'class' => 'form'] )!!}
@endif

{!!Form::text('nome', isset($carro->nome) ? $carro->nome : null , ['placeholder' => 'Nome do Carro', 'class' => 'form-control form-group'] )!!}
{!!Form::text('placa', isset($carro->placa) ? $carro->placa : null, ['placeholder' => 'Placa do Carro', 'class' => 'form-control form-group'] )!!}
{!!Form::select('id_marca', $marcas, isset($carro->id_marca) ? $carro->id_marca : null, ['class' => 'form-control form-group'])!!}
{!!Form::password('senha', isset($carro->senha) ? $carro->senha : null, ['placeholder' => 'Digite uma senha para o Carro', 'class' => 'form-control form-group'] )!!} ( Digite a senha do Carro )
{!!Form::file('file', ['class' => 'form-group'])!!}
{!!Form::submit('Enviar', ['class' => 'btn btn-default form-group'])!!}
{!!Form::close()!!}

@endsection