<?php
$path_root_home = dirname(__FILE__);
$DS = DIRECTORY_SEPARATOR;
$path_root_home = "{$path_root_home}{$DS}..{$DS}";
require_once "{$path_root_home}class{$DS}home.class.php";
$obj = new home();
switch($_REQUEST['action']){
	case 'addEnquete':
		$obj->setOpcao_enquete_opcao_id($_POST['opcao_voto']);
		if(!$obj->verifyVotos()){
			$aEnqRes = $obj->getEnqueteResult($_POST['enquete_id']);
			$aEnqRes['message'] = "Seu voto já foi computado!";
		}else{
			if($obj->saveVoto()==false){
				$aEnqRes['success'] = false;
				$aEnqRes['message'] = "Error ao computar o seu voto";
			}else{
				$aEnqRes = $obj->getEnqueteResult($_POST['enquete_id']);
				$aEnqRes['message'] = "Seu voto foi computado com sucesso!";
			}
		}
		echo json_encode($aEnqRes);
	break;
	case 'rss_noticias':
		// Define o tipo de conteúdo e o charset
		header("content-type: application/rss+xml; charset=utf-8");
		echo $obj->createRss(1);
	break;
	case 'rss_artigos':
		// Define o tipo de conteúdo e o charset
		header("content-type: application/rss+xml; charset=utf-8");
		echo $obj->createRss(2);
	break;
	case 'rss_analises':
		// Define o tipo de conteúdo e o charset
		header("content-type: application/rss+xml; charset=utf-8");
		echo $obj->createRss(3);
	break;
	case 'rss_destaque':
		// Define o tipo de conteúdo e o charset
		header("content-type: application/rss+xml; charset=utf-8");
		echo $obj->createRssDestaque();
	break;
	case 'rss_indicamos':
		// Define o tipo de conteúdo e o charset
		header("content-type: application/rss+xml; charset=utf-8");
		echo $obj->createRssIndicamos();
	break;


}
?>
