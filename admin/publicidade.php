<?php
	$path_root_publicidadeView = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_publicidadeView = "{$path_root_publicidadeView}{$DS}..{$DS}";
	include_once("{$path_root_publicidadeView}admin{$DS}includes{$DS}header.php");
	include_once("{$path_root_publicidadeView}admin{$DS}model{$DS}publicidade.class.php");
	$objPublicidade = new publicidade();
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
<script type="text/javascript" src="js/publicidade.js"></script>
<div id="grid"></div>
<?
	include_once("{$path_root_publicidadeView}admin{$DS}includes{$DS}footer.php");
?>