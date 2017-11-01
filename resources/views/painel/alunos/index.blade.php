@extends('painel.templates.index')

@section('content')

<h1 class="titulo-pg-painel">Listagem  dos Alunos ({{$alunos->count()}}):</h1>

<div class="divider"></div>

<div class="col-md-12">
    <form class="form-padrao form-inline padding-20 form-pesquisa" method="POST" send="http://127.0.0.1/painel/alunos/pesquisar/">
        <a href="" class="btn-cadastrar" data-toggle="modal" data-target="#modalGestao"><i class="fa fa-plus-circle"></i> Cadastrar</a>
        <input type="text" placeholder="Pesquisa" class="texto-pesquisa">
    </form>
    
    @if( isset($palavraPesquisa) )
        <p>Resultados para a pesquisa <b>{{$palavraPesquisa}}</b></p>
    @endif
</div>

<table class="table table-hover">
    <tr>
        <th>Nome</th>
        <th>Telefone</th>
        <th>Data Nascimento</th>
        <th>Matricula</th>
        <th>Turma</th>
        <th width="120px;"></th>
    </tr>
    @forelse($alunos as $aluno)
    <tr>
        <td>{{$aluno->nome}}</td>
        <td>{{$aluno->telefone}}</td>
        <td>{{$aluno->data_nascimento}}</td>
        <td>{{$aluno->matricula}}</td>
        <td>{{$aluno->turma}}</td>
        <td>
            <a href='{{url("http://127.0.0.1/painel/alunos/pais/{$aluno->id}")}}' class="edit">
                <i class="fa fa-users"></i>
            </a>
            <a class="edit" onclick="edit('http://127.0.0.1/painel/alunos/{{$aluno->id}}', 'id_turma')">
                <i class="fa fa-pencil-square-o"></i>
            </a>
            <a class="delete" onclick="del('http://127.0.0.1/painel/alunos/{{$aluno->id}}')">
                <i class="fa fa-times"></i>
            </a>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="500">Nenhum aluno cadastrado!</td>
    </tr>
    @endforelse
</table>

<nav>
    {!!$alunos->render()!!}
</nav>




<!-- Modal Para Gestão -->
<div class="modal fade" id="modalGestao" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-padrao4">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Gestão de Aluno</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning msg-war" role="alert" style="display: none"></div>
                <div class="alert alert-success msg-suc" role="alert" style="display: none"></div>

                <form class="form-padrao form-gestao" action="http://127.0.0.1/painel/alunos" send="http://127.0.0.1/painel/alunos">
                    <input type="hidden" id="_method" name="_method" value="POST" />

                    {!! csrf_field() !!}
                    <div class="form-group">
                        <input type="text" name="nome" class="form-control" placeholder="Nome do Aluno">
                    </div>
                    <div class="form-group">
                        <input type="text" name="telefone" id='telefone' class="form-control" placeholder="Telefone do Aluno">
                    </div>
                    <div class="form-group">
                        <input type="text" name="data_nascimento" id="data_nascimento" class="form-control" placeholder="Data Nascimento do Aluno">
                    </div>
                    <div class="form-group">
                        {!!Form::select('id_turma', $turmas, null, ['class' => 'form-control'])!!} 
                    </div>
                    
                    <div class="prelaoder" style="display: none">Enviando os dados, por favor aguarde...</div>
                        
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Salvar</button>
                
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')    
    <script>
        var urlAdd = 'http://127.0.0.1/painel/alunos';
    </script>
@endsection