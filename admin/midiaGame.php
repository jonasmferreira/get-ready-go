<?php
	$path_root_midiaGameView = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_midiaGameView = "{$path_root_midiaGameView}{$DS}..{$DS}";
	include_once("{$path_root_midiaGameView}admin{$DS}includes{$DS}header.php");
	include_once("{$path_root_midiaGameView}admin{$DS}model{$DS}midiaGame.class.php");
	$objMidiaGame= new midiaGame();
	$session = $objMidiaGame->getSessions();
	if(isset($session['msgEdit'])&&trim($session['msgEdit'])!=''){
		echo "
			<script type=\"text/javascript\">
				newAlert('{$session['msgEdit']}');
			</script>
		";
	}
	$objMidiaGame->unsetSession('msgEdit');
?>
<!-- js admin include -->
<script type="text/javascript" src="js/midiaGame.js"></script>
<div id="grid"></div>
<?	
	include_once("{$path_root_midiaGameView}admin{$DS}includes{$DS}footer.php");
?>