<?php
	$path_root_usuarioView = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_usuarioView = "{$path_root_usuarioView}{$DS}..{$DS}";
	include_once("{$path_root_usuarioView}admin{$DS}includes{$DS}header.php");
	include_once("{$path_root_usuarioView}admin{$DS}model{$DS}usuario.class.php");
	$objUsuario = new usuario();
	$session = $obj->getSessions();
	echo "
		<script type=\"text/javascript\">
			var usuario_id = '{$_REQUEST['usuario_id']}'
		</script>
	";
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
<script type="text/javascript" src="js/usuarioEdicao.js"></script>
<form class="jqtransform" id="formulario">
<div class="rowElem">
<label for="name">Name: </label>
<input type="text" name="name" />
</div>
<div class="rowElem"><input type="submit" value="send" /><div>
</form>
<?php
	include_once("{$path_root_usuarioView}admin{$DS}includes{$DS}footer.php");
?>