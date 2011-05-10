<?php
	$path_root_DefaultClass = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_DefaultClass = "{$path_root_DefaultClass}{$DS}..{$DS}..{$DS}";
	require_once "{$path_root_DefaultClass}admin{$DS}model{$DS}default.class.php";
	$obj = new DefaultClass();
	$obj->verifyLogin();
	$sessionAdmin = $obj->getSessions();
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
		
		<!-- Jquery Includes -->
		<link href="js/css/redmond/jquery-ui-1.8.11.custom.css" rel="stylesheet" type="text/css"  />
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/jquery-ui.js"></script>
		<script type="text/javascript" src="js/jquery.validate.min.js"></script>
		
		<!-- js default include -->
		<script type="text/javascript" src="js/utils.js"></script>
		
		
		<!-- js admin include -->
		<script type="text/javascript" src="js/admin.js"></script>
		
		<!-- CSS Principal -->
		<link href="css/principal.css" rel="stylesheet" type="text/css" />
		<link href="css/Icons.css" rel="stylesheet" type="text/css"  />
		<link href="css/forms.css" rel="stylesheet" type="text/css"  />
		

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
					Bem Vindo[a] <?=$sessionAdmin['usuario_nome']?> <br />
					Sistema de Gerenciamento de Conteúdo<br />
					Get Ready Go
				</div>
				<div id="logoff"><a href="javascript:void(0)" id="logoff" >Sair</a></div>
			</div>
			<div id="topmenu"></div>
		</div>
		<div id="main">