<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>{{$titulo or 'Login | Sistema em Laravel 5.5 SysTeach'}}</title>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="{{url('assets/painel/css/systeach.css')}}">
        <link rel="stylesheet" type="text/css" href="{{url('assets/painel/css/systeach-responsivo.css')}}">

        <!--JQuery-->
        <script src="//code.jquery.com/jquery-1.12.4.min.js"></script>
        
        <link rel="icon" type="image/png" href="{{url('assets/imgs/favicon.png')}}">
    </head>
    <body class="bg-padrao">

        <header>
            <h1 class="oculta">{{$titulo or 'Login | Sistema em Laravel 5.5 SysTeach'}}</h1>
        </header>

        <section class="login">
            <div class="topo-login">
                <h1 class="titulo-login">{{$titulo or 'Login SysTeach'}}</h1>
            </div>
            <div class="conteudo-login">
                @yield('form')
            </div>
        </section>


        <!-- Modal RecueraÃ§Ã£o de Senha -->
        <div class="modal fade" id="recuperarSenha" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-padrao2">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Recuperar Senha</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-padrao form-recuperar" method="POST">
                            <div class="alert alert-success success-msg" role="alert" style="display: none"></div>
                            <div class="alert alert-danger alert-recuperar" role="alert" style="display: none"></div>
                            
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <input type="text" name="email" class="form-control" placeholder="E-mail">
                            </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary btn-enviar-senha">Recuperar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
        <script>
            $(function(){
                jQuery('form.form').submit(function(){
                    jQuery(".alert-msg").hide();

                    var dadosForm = jQuery(this).serialize();

                    jQuery.ajax({
                        url: jQuery(this).attr("send"),
                        type: "POST",
                        data: dadosForm,
                        beforeSend: iniciaPreloader()
                    }).done(function(data){
                        finalizaPreloader();
                        if(data == "1"){
                            location.href="/painel";
                        }else{
                            jQuery(".alert-msg").show();
                            jQuery(".alert-msg").html(data);                    
                        }
                    }).fail(function(){
                        finalizaPreloader();
                        alert("Falha ao enviar Dados!");
                    });

                    return false;
                });
            });

            function iniciaPreloader(){
                jQuery(".btn-enviar").attr("disabled");
            }
            function finalizaPreloader(){
                jQuery(".btn-enviar").removeAttr("disabled");
            }
        </script>
        
        
        <script>
            $(function(){
                jQuery('form.form-recuperar').submit(function(){
                    jQuery(".alert-recuperar").hide();
                    jQuery(".success-msg").hide();

                    var dadosForm = jQuery(this).serialize();

                    jQuery.ajax({
                        url: "/recuperar-senha",
                        type: "POST",
                        data: dadosForm,
                        beforeSend: iniciaPreloaderRecuperarSenha()
                    }).done(function(data){
                        finalizaPreloaderRecuperarSenha();
                        if(data == "1"){
                            jQuery(".success-msg").show();
                            jQuery(".success-msg").html("Pedido de recuperação enviado para o seu e-mail.");
                        }else{
                            jQuery(".alert-recuperar").show();
                            jQuery(".alert-recuperar").html(data);                    
                        }
                    }).fail(function(){
                        finalizaPreloader();
                        alert("Falha ao enviar Dados!");
                    });

                    return false;
                });
            });

            function iniciaPreloaderRecuperarSenha(){
                jQuery(".btn-enviar-senha").attr("disabled");
            }
            function finalizaPreloaderRecuperarSenha(){
                jQuery(".btn-enviar-senha").removeAttr("disabled");
            }
        </script>
        
        
        @yield('scripts')
    </body>
</html>