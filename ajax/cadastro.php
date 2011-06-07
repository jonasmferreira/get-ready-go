<?php
	$path_root_cadastroController = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_cadastroController = "{$path_root_cadastroController}{$DS}..{$DS}";
	require_once "{$path_root_cadastroController}class/cadastro.class.php";
	$obj = new cadastro();
	switch($_REQUEST['action']){
		case 'cadastro':
			$obj->setValues($_POST);
			echo $obj->cadastrarUsuario();
		break;
		case 'verifyEmail':
			$obj->setValues($_POST);
			echo $obj->verifyEmail();
		break;
		case 'verifyLogin':
			$obj->setValues($_POST);
			echo $obj->verifyLogin();
		break;
	}
?>
