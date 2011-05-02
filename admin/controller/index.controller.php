<?php
	$path_root_indexController = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_indexController = "{$path_root_indexController}{$DS}..{$DS}..{$DS}";
	require_once "{$path_root_indexController}admin{$DS}model{$DS}index.class.php";
	$obj = new index();
	switch($_REQUEST['action']){
		case 'login':
			$obj->setValues($_POST);
			$result = $obj->logon();
			if($result===false){
				$obj->setSession('erro', 'Usuário e/ou Senha Inválida!');
				header('Location: ../index.php');
			}else{
				header('Location: ../admin.php');
			}
		break;
	}
?>
