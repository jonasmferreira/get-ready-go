<?php
	$path_root_adminView = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_adminView = "{$path_root_adminView}{$DS}..{$DS}";
	include_once("{$path_root_adminView}admin{$DS}includes{$DS}header.php");
	
?>

<?php
	include_once("{$path_root_adminView}admin{$DS}includes{$DS}footer.php");
?>
