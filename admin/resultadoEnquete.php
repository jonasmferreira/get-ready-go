<?php
	$path_root_resultadoEnqueteView = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_resultadoEnqueteView = "{$path_root_resultadoEnqueteView}{$DS}..{$DS}";
	include_once("{$path_root_resultadoEnqueteView}admin{$DS}includes{$DS}header.php");
	include_once("{$path_root_resultadoEnqueteView}admin{$DS}model{$DS}resultadoEnquete.class.php");
	$objresultadoEnquete = new resultadoEnquete();
	$session = $objresultadoEnquete->getSessions();
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
<script type="text/javascript" src="js/resultadoEnquete.js"></script>
<div id="grid"></div>
<?	
	include_once("{$path_root_resultadoEnqueteView}admin{$DS}includes{$DS}footer.php");
?>