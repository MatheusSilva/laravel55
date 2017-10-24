@extends('painel.templates.index')

@section('slide')
@parent
Conteúdo do slide
@endsection


@section('content')
<p>{!!Html::link('carros/adicionar', 'Cadastrar Novo Carro', ['class' => 'btn btn-success'])!!}</p>
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modalGestaoCarro">
    Cadastrar Carro Via Ajax
</button>
{!!Html::link('/carros/listar-via-ajax', 'Listar Carros Via Ajax', ['class' => 'btn btn-danger btn-lg', 'target' => '_blank'])!!}

<h1>Listagem dos carros do painel ({{$carros->total()}})</h1>
{!!'<h2>Olá eu sou um h2</h2>'!!}

<table class="table table-bordered">
    <tr>
        <th>Nome</th>
        <th>Placa</th>
        <th width="150">Ações</th>
    </tr>
    {{-- Listagem dos carros --}}
    @forelse( $carros as $carro )
    <tr>
        <td>{{$carro->nome}}</td>
        <td>{{$carro->placa}}</td>
        <td>{!! Html::link("carros/editar/{$carro->id}", 'Editar') !!} | {!! Html::link("carros/deletar/$carro->id", 'Deletar')!!}</td>
    </tr>
    @empty
    <p>Nenhum Carro Cadastrado!</p>
    @endforelse
</table>

{!!$carros->render()!!}

{{-- Inclusão da página de captura de e-mail --}}
@include('painel.includes.email')


<div class="modal fade" id="modalGestaoCarro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Gestão Carro</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-success" role="alert" style="display: none"></div>
                <div class="alert alert-warning" role="alert" style="display: none"></div>
                {!!Form::open( ['url' => 'carros/adicionar-via-ajax', 'send' => 'carros/adicionar-via-ajax', 'files' => true, 'class' => 'form'] )!!}
                    {!!Form::text('nome', null , ['placeholder' => 'Nome do Carro', 'class' => 'form-control form-group'] )!!}
                    {!!Form::text('placa', null, ['placeholder' => 'Placa do Carro', 'class' => 'form-control form-group'] )!!}
                    {!!Form::select('id_marca', $marcas, null, ['class' => 'form-control form-group'])!!}
                    
                    <div class="preloader" style="display: none">Enviando dados...</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                {!!Form::submit('Enviar', ['class' => 'btn btn-success form-group'])!!}
                {!!Form::close()!!}
            </div>
        </div>
    </div>
</div>

@endsection


@section('scripts')
<script>
    $(function(){
        jQuery("form.form").submit(function(){
            var dadosForm = jQuery(this).serialize();
            
            jQuery.ajax({
                url: jQuery(this).attr("send"),
                data: dadosForm,
                type: "POST",
                beforeSend: iniciaPreloader()
            }).done(function(data){
                finalizaPreloader();
                
                if(data == "1"){
                    location.reload();
                }else{
                    jQuery(".alert-warning").html(data);
                    jQuery(".alert-warning").show();
                }
            }).fail(function(){
                finalizaPreloader();
                
                alert("Falha ao enviar dados!");
            });
            
            
            return false;
        });
    });
    
    function iniciaPreloader(){
        jQuery(".preloader").show();
    }
    function finalizaPreloader(){
        jQuery(".preloader").hide();
    }
</script>
@endsection