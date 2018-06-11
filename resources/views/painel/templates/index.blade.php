<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>{{ $titulo or 'Painel | Sistema em Laravel 5.6' }}</title>

        <!-- Latest compiled and minified CSS -->
     
        {{ Html::style('assets/css/bootstrap.min.css') }}
        {{ Html::style('assets/css/sidebar.css') }}
        {{ Html::style('https://use.fontawesome.com/releases/v5.0.13/css/all.css') }}
        {{ Html::style('assets/painel/css/systeach.css') }}
        {{ Html::style('assets/painel/css/systeach-responsivo.css') }}
    </head>

    <body>
        <header>
            <h1 class="oculta">{{$titulo or 'Painel | Sistema em Laravel 5.6'}}</h1>
        </header>

        <section id="wrapper" class="painel toggled">
            <h1 class="oculta">Painel | SysTeach</h1>

            <div class="topo-painel col-md-12">
                <a href="" class="icon-acoes-painel">
                    <i class="fa fa-expand"></i>
                </a>

                {{ Html::image('assets/imgs/logo-systeach.png', 'SysTeach', ['class' => 'logo-painel', 'title' => 'SysTeach - Sistema em Laravel 5.6'])  }}

                <select class="acoes-painel">
                    <option value="{{Auth::user()->name}}">{{Auth::user()->name}}</option>
                    <option value="sair" class="sair">Sair</option>
                </select>
            </div>
            <!--End Top-->

            <!--Open Menu-->
            @include('painel.includes.menu')
            <!--End menu wrapper-->
           

            <section class="conteudo page-content-wrapper">
                <div class="cont container-fluid">
                    @yield('content')
                </div>
            </section>

            <!--End Conteudo-->
        </section>

        <!-- Modal Para Deletar Algo -->
        <div class="modal fade" id="modalConfirmacaoDeletar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                        <div class="modal-header bg-padrao5">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Deletar</h4>
                        </div>
                        <div class="modal-body">
                            {{Form::hidden('url-deletar', null, ['class' => 'url-deletar'])}}
                            <div class="preloader-deletar" style="display: none;">Deletando, por favor aguarde!!!</div>
                            <p>Deseja realmente deletar?</p>
                        </div>
                        <div class="modal-footer">
                            <meta name="csrf-token" content="{{ csrf_token() }}" />
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-danger btn-confirmar-deletar">Deletar</button>
                        </div>
                  </div>
              </div>
        </div>

        <!-- Latest compiled and minified JavaScript -->

        {{ Html::script('assets/js/jquery.min.js') }}

        {{ Html::script('assets/js/popper.min.js') }}

        {{ Html::script('assets/js/bootstrap.min.js') }}

        {{ Html::script('assets/js/jquery.mask.js') }}

        <!-- Final do Modal de Deletar -->

        @yield('scripts')
        
        <script>
           $(function(){
               jQuery("form.form-gestao").submit(function(){
                   jQuery(".msg-war").hide();
                   jQuery(".msg-suc").hide();
                   
                   var dadosForm = jQuery(this).serialize();
                   
                   var metodoEnvio = 'POST';

                   if (document.getElementById("_method").value != undefined && document.getElementById("_method").value != '') {
                      metodoEnvio = document.getElementById("_method").value;
                   }

                   jQuery.ajax({
                       url: jQuery(this).attr("send"),
                       data: dadosForm,
                       type: metodoEnvio,
                       beforeSend: iniciaPreloader()
                   }).done(function(data){
                       finalizaPreloader();
                       
                       if( data == "1" ){
                           jQuery(".msg-suc").html("Sucesso ao Salvar!");
                           jQuery(".msg-suc").show();
                           
                           setTimeout("jQuery('.msg-suc').hide();jQuery('#modalGestao').modal('hide');location.reload();", 4500);
                       }else{
                           jQuery(".msg-war").html(data);
                           jQuery(".msg-war").show();
                           
                           setTimeout("jQuery('.msg-war').hide();", 4500);
                       }
                   }).fail(function(){
                       finalizaPreloader();
                       alert("Falha Inesperada!");
                   });
                   
                   return false;
               });
           });
           
           
           function iniciaPreloader(){
               jQuery(".prelaoder").show();
           }
           function finalizaPreloader(){
               jQuery(".prelaoder").hide();
           }
           
           function edit(url, $keySelect = 'undefined')
           {
               jQuery.getJSON(url, function(data){
                   var ValueSelect = '';

                   jQuery.each(data, function(key, val){

                       jQuery("input[name='"+key+"']").attr("value", val);
                       
                       ValueSelect = jQuery("option[value='"+val+"']").val();

                       if(key === $keySelect && ValueSelect === val) {
                           jQuery("option[value='"+val+"']").attr("selected", true);
                       } else if(key === $keySelect && ValueSelect == val) {
                           jQuery("option[value='"+val+"']").attr("selected", true);
                       }
                   });
               });
               
               var method = "PUT";

               jQuery("#modalGestao").modal();
               
               document.getElementById("_method").value = 'PUT';
               jQuery("form.form-gestao").attr("data-method", method);
               jQuery("form.form-gestao").attr("method", method);
               jQuery("form.form-gestao").attr("send", url);
               jQuery("form.form-gestao").attr("action", url);
           }
           
           
           function del(url){
                //alert(url);exit;
               jQuery(".url-deletar").val(url);
               
               jQuery("#modalConfirmacaoDeletar").modal();
           }
           
           jQuery(".btn-confirmar-deletar").click(function(){
               var method = "DELETE";

               //document.getElementById("_method").value = method;
               //jQuery("form.form-gestao").attr("data-method", method);
               //jQuery("form.form-gestao").attr("method", method);
               var url = jQuery(".url-deletar").val(); 
               jQuery("form.form-gestao").attr("send", url);
               jQuery("form.form-gestao").attr("action", url);
               //jQuery("#frmDelete").attr("action", url);
               
               //Content-Type:application/x-www-form-urlencoded; charset=UTF-8

               //var jForm = new FormData();
               //jForm.append("_token", document.getElementsByName("_token")[0].value);

               //var jdata = {"_method":"DELETE", "_token":"\""+document.getElementsByName("_token")[0].value+"\""}

               jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
               });

               jQuery.ajax({
                   url: url,
                   type: "DELETE",
                   //data: jdata,
                  
                   beforeSend: inicializaPreloaderDeletar()
               }).done(function(data){
                   finalizaPreloaderDeletar();
                   
                   if( data == "1" ){
                        location.reload();
                    }else{
                        alert("Falha ao deletar");
                    }
               }).fail(function(){
                   finalizaPreloaderDeletar();
                   alert("Falha ao enviar dados!");
               });
               
               
           });
           
           function inicializaPreloaderDeletar(){
               jQuery(".preloader-deletar").show();
           }
           function finalizaPreloaderDeletar(){
               jQuery(".preloader-deletar").hide();
           }
           
           
           jQuery("form.form-pesquisa").submit(function(){
               var textoPesquisa = jQuery(".texto-pesquisa").val();
               var url = jQuery(this).attr("send");
               
               location.href = url+textoPesquisa;
               
               return false;
           });
           
           
           jQuery(".acoes-painel").change(function(){
               if( jQuery(this).val() == "sair" )
               {
                   location.href = "{{url('/logout')}}";
               }
           });
           
           
           jQuery(".btn-cadastrar").click(function(){
               jQuery("form.form-gestao").attr("send", urlAdd);
               jQuery("form.form-gestao").attr("action", urlAdd);
               
               /*
                jQuery("form.form-gestao").each(function(){
                   this.reset;
               });
               * 
                */
               jQuery(":input[type='text']").attr("value", "");
               
                jQuery("#telefone").mask("(00)00000-0000");
                jQuery("#data_nascimento").mask("00/00/0000");
           });
        </script>
    </body>
</html>