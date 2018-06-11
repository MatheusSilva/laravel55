@extends('painel.templates.index')

@section('content')

<a href="{{url('/painel/pais')}}">
    <i class="fa fa-angle-double-left"></i> Voltar Para a Listagem de Pais
</a>

<h1 class="titulo-pg-painel">Listagem  das Turmas ({{$data->count()}}):</h1>

<div class="divider"></div>

<div class="col-md-12">
    <form class="form-padrao form-inline padding-20 form-pesquisa" method="POST" send="turmas/pesquisar-turmas/">
        <a href="" class="btn-cadastrar" data-toggle="modal" data-target="#modalGestao"><i class="fa fa-plus-circle"></i> Cadastrar</a>
        <input type="text" placeholder="Pesquisa" class="texto-pesquisa">
    </form>
    
    @if( isset($palavraPesquisa) )
        <p>Resultados para a pesquisa <b>{{$palavraPesquisa}}</b></p>
    @endif
</div>

<table class="table table-hover">
    <tr>
        <th scope="col">Nome</th>
        <th scope="col" width="150">Ações</th>
    </tr>
    @forelse($data as $turma)
    <tr>
        <td>{{$turma->nome}}</td>
        <td>
            <a class="edit" onclick="edit('turmas/{{$turma->id}}')">
                <i class="far fa-edit"></i>
            </a>
            <a class="delete" onclick="del('turmas/{{$turma->id}}')">
                <i class="fa fa-times"></i>
            </a>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="500">Nenhuma turma cadastrada!</td>
    </tr>
    @endforelse
</table>

<nav>
    {!!$data->render()!!}
</nav>




<!-- Modal Para Gestão -->
<div class="modal fade" id="modalGestao" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-padrao4">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Gestão de Turma</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning msg-war" role="alert" style="display: none"></div>
                <div class="alert alert-success msg-suc" role="alert" style="display: none"></div>

                <form class="form-padrao form-gestao" action="turmas" send="turmas">
                    <input type="hidden" id="_method" name="_method" value="POST" />

                    {!! csrf_field() !!}
                    <div class="form-group">
                        <input type="text" name="nome" class="form-control" placeholder="Numero da Turma">
                    </div>
                    
                    <div class="prelaoder" style="display: none">Enviando os dados, por favor aguarde...</div>
                        
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary" id="btnSalvar" >Salvar</button>
                
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')    
    <script>
        var urlAdd = 'turmas';
    </script>
@endsection