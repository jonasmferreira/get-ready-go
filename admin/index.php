<?php
	$path_root_indexPage = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_indexPage = "{$path_root_indexPage}{$DS}..{$DS}";
	require_once "{$path_root_indexPage}admin{$DS}model{$DS}index.class.php";
	$obj = new index();
	
	$session = $obj->getSessions();
	if(isset($session['usuario_id'])&&trim($session['usuario_id'])!=''){
		header('Location: admin.php');
	}
	$erro = $session['erro'];
	$obj->unsetSession('session');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Sistema de Gerenciamento de Conteúdo - Get Ready Go - Login</title>
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
		
		<!-- Jquery Includes -->
		<link href="js/css/redmond/jquery-ui-1.8.11.custom.css" rel="stylesheet" type="text/css"  />
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/jquery-ui.js"></script>
		
		<!-- js default include -->
		<script type="text/javascript" src="js/utils.js"></script>
		
		<!-- CSS Principal -->
		<link href="css/login.css" rel="stylesheet" type="text/css" />
		
		<!-- js admin include -->
		<script type="text/javascript" src="js/index.js"></script>
	</head>
	<body>
		<div class="header">
			<img src="img/logo.png" alt="Sistema de Gerenciamento de Conteúdo - Get Ready Go" />
		</div>
		<div class="form">
			<div class="error">
				<?=$erro?>
			</div>
			<form name="frmlogin" id="frmlogin" method="post" action="controller/index.controller.php">
				<input type="hidden" name="action" id="action" value="login" />

				<label for="user">Usuário:</label>
				<input type="text" name="login" id="login" maxlength="32" class="obrigatorio" />

				<label for="password">Senha:</label>
				<input type="password" id="senha" name="senha" maxlength="32" class="obrigatorio" />

				<input type="submit" id="enviar" name="login" value="Enviar" />
			</form>
		</div>
		<div class="footer">Sistema de Gerenciamento de Conteúdo - Get Ready Go</div>
	</body>
</html>