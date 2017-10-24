@extends('auth.templates.index')

@section('form')
<form class="form-padrao form" method="POST" action="/login" send="/login">
    <div class="alert alert-danger alert-msg" role="alert" style="display: none"></div>
    
    {!! csrf_field() !!}
    <div class="form-group">
        <input type="text" name="email" class="form-control" placeholder="Usuário">
    </div>
    <div class="form-group">
        <input type="password" name="password" class="form-control" placeholder="Senha">
    </div>
    <a href="" class="recuperar-senha" data-toggle="modal" data-target="#recuperarSenha">Esqueceu a Senha?</a>

    <input type="submit" name="btn-enviar" value="Entrar" class="btn-padrao btn-enviar">
</form>
@endsection

@section('scripts')

@endsection