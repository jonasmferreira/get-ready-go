<?php
	include_once 'includes/cabecalho.php';
	include_once 'includes/header2.php';
	include_once 'class/meu_perfil.class.php';
	$obj = new meu_perfil();
	$obj->setUsuario_id($_GET['usuario_id']);
	$aPerfil = $obj->perfil();
?>

<img src="<?php echo $linkAbsolute ?>imgs/content_top.png" align="absbottom" style="display:block; margin:auto" />
<div id="conteudo" class="sistema">
	<!-- nome da seção -->
	<h2><b class="title">perfil de usuário</b></h2>

	<div id="perfil">
		<div id="imgPerfil">
			<?php if($aPerfil['usuario_avatar']==''){ ?>
			<img src="<?php echo $linkAbsolute ?>imgs/avatares/1.jpg" class="avatar" />
			<?php }else{ ?>
			<?php
				if(@file_get_contents("{$linkAbsolute}avatars/{$aPerfil['usuario_avatar']}")==true){
					$file = "{$linkAbsolute}avatars/{$aPerfil['usuario_avatar']}";
				}else{
					$file = "{$linkAbsolute}avatar_user/{$aPerfil['usuario_avatar']}";
				}
			?>
			<img src="<?php echo "{$file}" ?>" class="avatar" width="140px" height="140px" />
			<?php } ?>
		</div>

		<div id="infoPerfil">
			<h1><?php echo $aPerfil['usuario_nome'] ?></h1>
			<?php echo $aPerfil['usuario_perfil'] ?>
			<p class="data">cadastrado em 21.11.2010</p>
		</div>
		<div style="clear:both"></div>
	</div>

</div>
<img src="<?php echo $linkAbsolute ?>imgs/content_bot.png" align="top"  style="display:block; margin:auto; clear:both" />
<?php
	include_once 'includes/footer2.php';
?>
