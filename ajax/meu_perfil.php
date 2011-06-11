<?php
$path_root_meuPerfil = dirname(__FILE__);
$DS = DIRECTORY_SEPARATOR;
$path_root_meuPerfil = "{$path_root_meuPerfil}{$DS}..{$DS}";
require_once "{$path_root_meuPerfil}class{$DS}meu_perfil.class.php";
$obj = new meu_perfil();

switch($_REQUEST['action']){
	case 'savePerfil':
		$obj->setValues($_POST);
		echo $obj->savePerfil();
	break;
	case 'alteraAvatar':
		$obj->setValues($_POST);
		echo $obj->alteraAvatar();
	break;
}
?>
