<?php
	include_once 'includes/cabecalho.php';
	include_once 'includes/header2.php';
?>
<!-- Conteúdo -->
<img src="imgs/content_top.png" align="absbottom" style="display:block; margin:auto" />
<div id="conteudo" class="sistema">
	<!-- Últimas Notícias -->
	<h2><b class="title">cadastro</b></h2>
	<p align="center" class="red"><strong>Nome de usuário indisponível.</strong></p><!-- Mensagem de erro -->
	<div style="width:344px; margin:auto;">
		<p><label>Nome de usuário:</label><br /><input type="text" class="text" size="50" /></p>
		<p><label>E-mail:</label><br /><input type="text" class="text" size="50" /></p>
		<p><label>Senha:</label><br /><input type="text" class="text" size="50" /></p>
		<p><input type="image" src="imgs/bt_enviar.gif" /></p>
	</div>
</div>
<img src="imgs/content_bot.png" align="top"  style="display:block; margin:auto; clear:both" />
<?php include_once 'includes/footer2.php'; ?>