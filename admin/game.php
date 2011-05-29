<?php
	$path_root_gameView = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_gameView = "{$path_root_gameView}{$DS}..{$DS}";
	include_once("{$path_root_gameView}admin{$DS}includes{$DS}header.php");
	include_once("{$path_root_gameView}admin{$DS}model{$DS}game.class.php");
	$objGame = new game();
	$session = $objGame->getSessions();
	if(isset($session['msgEdit'])&&trim($session['msgEdit'])!=''){
		echo "
			<script type=\"text/javascript\">
				newAlert('{$session['msgEdit']}');
			</script>
		";
	}
	$objGame->unsetSession('msgEdit');
?>
<!-- js admin include -->
<script type="text/javascript" src="js/game.js"></script>
<div id="grid"></div>
<?	
	include_once("{$path_root_gameView}admin{$DS}includes{$DS}footer.php");
?>