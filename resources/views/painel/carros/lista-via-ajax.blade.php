@extends('painel.templates.index')

@section('content')
<h1>Listagem dos carros via ajax</h1>

<table class="table table-bordered">
    <tr>
        <th>Nome</th>
        <th>Placa</th>
    </tr>
</table>
<div class="prelaoder" style="display: none;">Listando os dados, por favor aguarde...</div>
@endsection


@section('scripts')
<script>
    $(function(){
        jQuery.ajax({
            url: "../painel/carros/carros-ajax",
            type: "GET",
            dataType: "JSON",
            beforeSend: inicializaPreloader()
        }).done(function(data){
            finalizaPreloader();
            
            jQuery.each(data, function(key, value){
                jQuery(".table").append("<tr><td>"+value.nome+"</td><td>"+value.placa+"</td></tr>");
            });
        }).fail(function(){
            finalizaPreloader();
            alert("Fail send data");
        });
    });
    
    function inicializaPreloader(){
        jQuery(".prelaoder").show();
    }
    function finalizaPreloader(){
        jQuery(".prelaoder").hide();
    }
</script>
@endsection