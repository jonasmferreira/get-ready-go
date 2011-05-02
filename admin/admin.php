<?php
	$path_root_DefaultClass = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_DefaultClass = "{$path_root_DefaultClass}{$DS}..{$DS}";
	require_once "{$path_root_DefaultClass}admin{$DS}model{$DS}default.class.php";
	$obj = new DefaultClass();
	$obj->verifyLogin();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Sistema de Gerenciamento de Conteúdo - Get Ready Go</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<!-- Ext includes -->
		<link rel="stylesheet" type="text/css" href="js/ext-4.0.0/resources/css/ext-all.css" />
		<script type="text/javascript" src="js/ext-4.0.0/bootstrap.js"></script>
		
		<!-- Shared example includes -->
		<script type="text/javascript" src="js/menus.js"></script>
		
		<script type="text/javascript" src="js/ext-4.0.0/examples/shared/examples.js"></script>
		<script type="text/javascript" src="js/ext-4.0.0/examples/shared/states.js"></script>
		
		<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
		
		<!-- CSS Principal -->
		<link rel="stylesheet" type="text/css" href="css/principal.css" />

		<script>
			$(document).ready(function() {
				/*$('#accordion h3').click(function() {
					$(this).next().toggle('slow');
					return false;
				}).next().hide();*/
			});
		</script>
	</head>
	<body>
		
		<div id="header">
			<div id="area">
				<div id="logo">&nbsp;</div>
				<div id="info">
					Bem Vindo[a] Jonas <br />
					Sistema de Gernciamento de Conteúdo<br />
					Get Ready Go
				</div>
				<div id="logoff"></div>
			</div>
			<div id="topmenu"></div>
		</div>
		<div id="main"></div>
		<div id="footer">
			<div id="area">Copyright &copy; 2011 - Get Ready Go - Todos os direitos reservados </div>
		</div>
	</body>
</html>
