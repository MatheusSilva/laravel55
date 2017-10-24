@extends('painel.templates.index')

@section('content')
	<h1>Cache de carros</h1>

	<ul>
		@foreach ($carros as $carro)
	    	<li>{{$carro->nome}} - {{$carro->placa}} | </li>
		@endforeach
	</ul>

	<br>
	
	<ul>
		<li><b>Titulo Criptografado:</b> {{$titulo}}</li>
		<li><b>Titulo Descriptografado:</b> {{Crypt::decrypt($titulo)}}</li>
	</ul>

@endsection