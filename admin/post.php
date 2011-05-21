<?php
	$path_root_postView = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_postView = "{$path_root_postView}{$DS}..{$DS}";
	include_once("{$path_root_postView}admin{$DS}includes{$DS}header.php");
	include_once("{$path_root_postView}admin{$DS}model{$DS}post.class.php");
	$objPost = new post();
	$session = $objPost->getSessions();
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
<script type="text/javascript" src="js/post.js"></script>
<div id="grid"></div>
<?	
	include_once("{$path_root_postView}admin{$DS}includes{$DS}footer.php");
?>