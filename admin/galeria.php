<?php
	$path_root_galeriaView = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_galeriaView = "{$path_root_galeriaView}{$DS}..{$DS}";
	include_once("{$path_root_galeriaView}admin{$DS}includes{$DS}header.php");
	include_once("{$path_root_galeriaView}admin{$DS}model{$DS}galeria.class.php");
	$objgaleria = new galeria();
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
<script type="text/javascript" src="js/galeria.js"></script>
<div id="grid"></div>
<?	
	include_once("{$path_root_galeriaView}admin{$DS}includes{$DS}footer.php");
?>