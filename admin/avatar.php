<?php
	$path_root_avatarView = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_avatarView = "{$path_root_avatarView}{$DS}..{$DS}";
	include_once("{$path_root_avatarView}admin{$DS}includes{$DS}header.php");
	include_once("{$path_root_avatarView}admin{$DS}model{$DS}avatar.class.php");
	$objAvatar = new avatar();
	$session = $objAvatar->getSessions();
	if(isset($session['msgEdit'])&&trim($session['msgEdit'])!=''){
		echo "
			<script type=\"text/javascript\">
				newAlert('{$session['msgEdit']}');
			</script>
		";
	}
	$objAvatar->unsetSession('msgEdit');
?>
<!-- js admin include -->
<script type="text/javascript" src="js/avatar.js"></script>
<div id="grid"></div>
<?	
	include_once("{$path_root_avatarView}admin{$DS}includes{$DS}footer.php");
?>