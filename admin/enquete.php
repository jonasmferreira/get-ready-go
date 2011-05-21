<?php
	$path_root_enqueteView = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_enqueteView = "{$path_root_enqueteView}{$DS}..{$DS}";
	include_once("{$path_root_enqueteView}admin{$DS}includes{$DS}header.php");
	include_once("{$path_root_enqueteView}admin{$DS}model{$DS}enquete.class.php");
	$objenquete = new enquete();
	$session = $objenquete->getSessions();
	if(isset($session['msgEdit'])&&trim($session['msgEdit'])!=''){
		echo "
			<script type=\"text/javascript\">
				newAlert('{$session['msgEdit']}');
			</script>
		";
	}
	$objenquete->unsetSession('msgEdit');
?>
<!-- js admin include -->
<script type="text/javascript" src="js/enquete.js"></script>
<div id="grid"></div>
<?	
	include_once("{$path_root_enqueteView}admin{$DS}includes{$DS}footer.php");
?>