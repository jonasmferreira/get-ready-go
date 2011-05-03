<?php
	$path_root_usuarioView = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_usuarioView = "{$path_root_usuarioView}{$DS}..{$DS}";
	include_once("{$path_root_usuarioView}admin{$DS}includes{$DS}header.php");
	include_once("{$path_root_usuarioView}admin{$DS}model{$DS}usuario.class.php");
	$objUsuario = new usuario();
?>
<!-- js admin include -->
<script type="text/javascript" src="js/usuario.js"></script>
<div id="grid">aaaa</div>
<?	
	include_once("{$path_root_usuarioView}admin{$DS}includes{$DS}footer.php");
?>