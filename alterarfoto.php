<?php
	if(count($_FILES)>0){
		$path_root_avatarClass = dirname(__FILE__);
		$DS = DIRECTORY_SEPARATOR;
		$path_root_avatarClass = "{$path_root_avatarClass}{$DS}";
		$avatarFolder = "{$path_root_avatarClass}avatar_user{$DS}";
		if(!is_dir($avatarFolder)){
			mkdir($avatarFolder,0777);
			chmod($avatarFolder,0777);
		}
		$fileNameImagem = str_replace(".","",microtime(true))."_".$_FILES['avatar_imagem']['name'];
		if(move_uploaded_file($_FILES['avatar_imagem']['tmp_name'], $avatarFolder.$fileNameImagem)){
			die("Success");
		}else{
			die("Error");
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Alteração foto do avatar</title>
		<style type="text/css">
			h1{font-style: italic;}
		</style>
		<link href="style.css" media="screen" rel="stylesheet" type="text/css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
		<script>
			$(document).ready(function(){
			});
		</script>
	</head>
	<body>
		<form style="margin: 5px;padding: 5px;" method="POST" enctype="multipart/form-data">
			<div style="margin: 0 auto;text-align: center">
				<input type="file" name="avatar_imagem" id="avatar" />
			</div>
			<div style="margin: 10px auto 0 auto;text-align: center">
				<input type="image" src="<?php echo $linkAbsolute ?>imgs/bt_enviar.gif" />
			</div>
		</form>
	</body>
</html>