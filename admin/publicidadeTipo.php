<?php
	$path_root_publicidadeTipoView = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_publicidadeTipoView = "{$path_root_publicidadeTipoView}{$DS}..{$DS}";
	include_once("{$path_root_publicidadeTipoView}admin{$DS}includes{$DS}header.php");
	include_once("{$path_root_publicidadeTipoView}admin{$DS}model{$DS}publicidadeTipo.class.php");
	$objpublicidadeTipo = new publicidadeTipo();
	$session = $objpublicidadeTipo->getSessions();
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
<script type="text/javascript" src="js/publicidadeTipo.js"></script>
<div id="grid"></div>
<?
	include_once("{$path_root_publicidadeTipoView}admin{$DS}includes{$DS}footer.php");
?>