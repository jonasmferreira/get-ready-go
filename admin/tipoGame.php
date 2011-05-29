<?php
	$path_root_tipoGameView = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_tipoGameView = "{$path_root_tipoGameView}{$DS}..{$DS}";
	include_once("{$path_root_tipoGameView}admin{$DS}includes{$DS}header.php");
	include_once("{$path_root_tipoGameView}admin{$DS}model{$DS}tipoGame.class.php");
	$objTipoGame= new tipoGame();
	$session = $objTipoGame->getSessions();
	if(isset($session['msgEdit'])&&trim($session['msgEdit'])!=''){
		echo "
			<script type=\"text/javascript\">
				newAlert('{$session['msgEdit']}');
			</script>
		";
	}
	$objTipoGame->unsetSession('msgEdit');
?>
<!-- js admin include -->
<script type="text/javascript" src="js/tipoGame.js"></script>
<div id="grid"></div>
<?	
	include_once("{$path_root_tipoGameView}admin{$DS}includes{$DS}footer.php");
?>