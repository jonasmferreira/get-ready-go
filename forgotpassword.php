<?php
	include_once 'includes/cabecalho.php';
	include_once 'includes/header2.php';
?>
		<script type="text/javascript" src="<?php echo $linkAbsolute?>js/forgotpassword.js"></script>
        <!-- Conteudo -->
        <div id="miolo">
           
            <!-- Conteúdo -->
			<img src="imgs/content_top.png" align="absbottom" style="display:block; margin:auto" />
            <div id="conteudo" class="sistema">
				<!-- Últimas Notícias -->
				<h2><b class="title">esqueceu sua senha?</b></h2>
                <p align="center">Escreva seu endereço de e-mail no espaço abaixo e clique em "enviar".</p>
                <p align="center">
                	<table align="center">
                    	<tr>
                        	<td><strong>Endereço de e-mail</strong></td>
                            <td><input type="text" class="text" size="50" name="email_reset" id="email_reset" /></td>
                            <td><input type="image" src="imgs/bt_enviar.gif" id="enviar_resetpassword" style="cursor:pointer;" /></td>
                        </tr>
                    </table>
                </p>
                <p align="center">Enviaremos um e-mail com instruções de como resetar sua senha.</p>
				<div id="respostaResetPassword"></div>
				<!-- p align="center" class="green"><strong>E-mail enviado com sucesso!</strong></p --><!-- Mensagem de sucesso -->
				<!-- p align="center" class="red"><strong>Falha no envio, tente outra vez mais tarde.</strong></p--><!-- Mensagem de erro -->
            </div>
            <img src="imgs/content_bot.png" align="top"  style="display:block; margin:auto; clear:both" />
        
        </div>
    </div>
</div>
</body>
</html>
