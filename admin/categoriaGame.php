<?php
	$path_root_categoriaGameView = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_categoriaGameView = "{$path_root_categoriaGameView}{$DS}..{$DS}";
	include_once("{$path_root_categoriaGameView}admin{$DS}includes{$DS}header.php");
	include_once("{$path_root_categoriaGameView}admin{$DS}model{$DS}categoriaGame.class.php");
	$objCategoriaGame= new categoriaGame();
	$session = $objCategoriaGame->getSessions();
	if(isset($session['msgEdit'])&&trim($session['msgEdit'])!=''){
		echo "
			<script type=\"text/javascript\">
				newAlert('{$session['msgEdit']}');
			</script>
		";
	}
	$objCategoriaGame->unsetSession('msgEdit');
?>
<!-- js admin include -->
<script type="text/javascript" src="js/categoriaGame.js"></script>
<div id="grid"></div>
<?	
	include_once("{$path_root_categoriaGameView}admin{$DS}includes{$DS}footer.php");
?>