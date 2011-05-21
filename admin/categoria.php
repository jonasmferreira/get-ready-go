<?php
	$path_root_categoriaView = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_categoriaView = "{$path_root_categoriaView}{$DS}..{$DS}";
	include_once("{$path_root_categoriaView}admin{$DS}includes{$DS}header.php");
	include_once("{$path_root_categoriaView}admin{$DS}model{$DS}categoria.class.php");
	$objCategoria= new categoria();
	$session = $objCategoria->getSessions();
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
<script type="text/javascript" src="js/categoria.js"></script>
<div id="grid"></div>
<?	
	include_once("{$path_root_categoriaView}admin{$DS}includes{$DS}footer.php");
?>