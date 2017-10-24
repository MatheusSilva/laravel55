@extends('painel.templates.index')

@section('content')
<p>{!!Html::link('users/adicionar', 'Cadastrar Novo Usuário', ['class' => 'btn btn-success'])!!}</p>

<h1>Listagem dos usuários do painel ({{$users->total()}})</h1>

@if($status != "")
{{$status}}
@endif

<table class="table table-bordered">
    <tr>
        <th>Nome</th>
        <th>E-mail</th>
        <th width="150">Ações</th>
    </tr>
    {{-- Listagem dos carros --}}
    @forelse( $users as $user )
    <tr>
        <td>{{$user->name}}</td>
        <td>{{$user->email}}</td>
        <td>{!! Html::link("users/{$user->id}", 'Editar') !!} | {!! Html::link("users/deletar/$user->id", 'Deletar')!!}</td>
    </tr>
    @empty
    <p>Nenhum Usuário Cadastrado!</p>
    @endforelse
</table>

{!!$users->render()!!}

@endsection