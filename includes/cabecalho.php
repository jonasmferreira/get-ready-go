<?php
	session_name('GET_READY_GO_2011_SITE');
	if(session_id()==''){
		session_start();
	}
	//echo "<pre>".print_r($_SESSION,true)."</pre>";
	//echo "<pre>".print_r($_SERVER,true)."</pre>";
	$linkAbsolute = "http://localhost/get/";
	//$linkAbsolute = "http://getreadygo.cdanime.com/";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Get Ready... Go!</title>
		<link href="<?php echo $linkAbsolute?>style.css" media="screen" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="<?php echo $linkAbsolute?>js/jquery.js"></script>
		<script type="text/javascript" src="<?php echo $linkAbsolute?>js/basic.js"></script>
		<script type="text/javascript" src="<?php echo $linkAbsolute?>js/login.js"></script>
		<script type="text/javascript" src="<?php echo $linkAbsolute?>js/jquery.raty.js"></script>
		
		
		
	</head>
	<body>
	<input type="hidden" id="linkAbsolute" name="linkAbsolute" value="<?php echo $linkAbsolute?>" />