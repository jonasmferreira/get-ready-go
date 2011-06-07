<?php
	include_once 'includes/cabecalho.php';
	include_once 'includes/header2.php';
?>
<!-- Conteúdo -->
<script type="text/javascript" src="<?php echo $linkAbsolute?>js/cadastro.js"></script>
<img src="imgs/content_top.png" align="absbottom" style="display:block; margin:auto" />
<div id="conteudo" class="sistema">
	<!-- Últimas Notícias -->
	<h2><b class="title">cadastro</b></h2>
	<div id="respostacadastra_usuario"></div>
	<!-- p align="center" class="red"><strong>Nome de usuário indisponível.</strong></p --><!-- Mensagem de erro -->
	<div style="width:344px; margin:auto;">
		<p><label>Nome:</label><br /><input type="text" class="text" size="50" name="usuario_cad" id="usuario_cad" /></p>
		<p><label>Login:</label><br /><input type="text" class="text" size="50" name="login_cad" id="login_cad" /></p>
		<p><label>E-mail:</label><br /><input type="text" class="text" size="50" name="email_cad" id="email_cad" /></p>
		<p><label>Senha:</label><br /><input type="password" class="text" size="50" name="senha_cad" id="senha_cad" /></p>
		<p><input type="image" src="imgs/bt_enviar.gif" id="cadastra_usuario"/></p>
	</div>
</div>
<img src="imgs/content_bot.png" align="top"  style="display:block; margin:auto; clear:both" />
<?php include_once 'includes/footer2.php'; ?>