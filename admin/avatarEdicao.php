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

	$session = $objAvatar->setValues($_REQUEST);
	if(!empty($_REQUEST['avatar_id'])){
		$res = $objAvatar->getOne();
	}
?>

<!-- js admin include -->
<script type="text/javascript" src="js/avatarEdicao.js"></script>
<div class="form-main">
	<div class="legend" >Avatar - <?php echo empty($res['avatar_id']) ? 'Cadastro' : 'Edição' ?></div>
	<div class="forms cadastros">
		<form action="controller/avatar.controller.php?action=edit" method="post" id="formSalvar" enctype="multipart/form-data">
			<input type="hidden" name="avatar_id" id="avatar_id" value="<?php echo empty($res['avatar_id']) ? '' : $res['avatar_id'] ?>" />
			<ul style="width:600px">
				<li>Título:</li>
				<li><input type="text" name="avatar_titulo" class="obrigatorio" id="avatar_titulo" value="<?php echo empty($res['avatar_titulo']) ? '' : $res['avatar_titulo'] ?>" /></li>
			</ul><br clear="all" />
			<ul style="width:600px">
				<li>Avatar:</li>
				<li><input type="file" name="avatar_imagem" id="avatar_imagem" value="" /></li>
			</ul><br clear="all" />
			<ul style="width:600px">
				<li>Avatar Cadastrado:</li>
				<li>
					<?	if(is_file("{$path_root_avatarView}avatar_user{$DS}{$res['avatar_imagem']}")):?>
					<img src="../avatar_user/<?=$res['avatar_imagem']?>" border="0" alt="avatar" />
					<?	else:?>
					Nenhum Avatar
					<?	endif;?>
				</li>
			</ul>
		</form>
	</div>
	<div class="botoes">
		<button id="salvar">Salvar</button>
		<button id="limparCadastro">Limpar</button>
		<button id="voltar">Voltar</button>

	</div>
</div>
<?php
	include_once("{$path_root_avatarView}admin{$DS}includes{$DS}footer.php");
?>