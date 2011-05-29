<?php
	$path_root_comentarioView = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_comentarioView = "{$path_root_comentarioView}{$DS}..{$DS}";
	include_once("{$path_root_comentarioView}admin{$DS}includes{$DS}header.php");
	include_once("{$path_root_comentarioView}admin{$DS}model{$DS}comentario.class.php");
	$objcomentario= new comentario();
	$session = $objcomentario->getSessions();
	if(isset($session['msgEdit'])&&trim($session['msgEdit'])!=''){
		echo "
			<script type=\"text/javascript\">
				newAlert('{$session['msgEdit']}');
			</script>
		";
	}
	$obj->unsetSession('msgEdit');
?>
<!-- js admin include -->
<script type="text/javascript" src="js/comentario.js"></script>
<div id="grid"></div>
<?
	include_once("{$path_root_comentarioView}admin{$DS}includes{$DS}footer.php");
?>