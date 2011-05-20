<?php
	$path_root_usuarioView = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_usuarioView = "{$path_root_usuarioView}{$DS}..{$DS}";
	include_once("{$path_root_usuarioView}admin{$DS}includes{$DS}header.php");
	include_once("{$path_root_usuarioView}admin{$DS}model{$DS}usuario.class.php");
	$objUsuario = new usuario();
	$aUsuarioNivel = $objUsuario->getUsuarioNivel(false);
	
	$session = $objUsuario->getSessions();
	if(isset($session['msgEdit'])&&trim($session['msgEdit'])!=''){
		echo "
			<script type=\"text/javascript\">
				newAlert('{$session['msgEdit']}');
			</script>
		";
	}
	$obj->unsetSession('msgEdit');
	
	echo "<pre>" . print_r($_REQUEST,true) . "</pre>";

	$session = $objUsuario->setValues($_REQUEST);
	if(!empty($_REQUEST)){
		$res = $objUsuario->getOne();
	}
?>

<!-- js admin include -->
<script type="text/javascript" src="js/usuarioEdicao.js"></script>
<div class="form-main">
	<div class="legend" >Usuários - <?php echo empty($res['usuario_id']) ? 'Cadastro' : 'Edição' ?></div>
	<div class="forms cadastros">
		<form action="controller/usuario.controller.php?action=edit" method="post" id="formSalvar" enctype="multipart/form-data">
			<input type="hidden" name="usuario_id" id="usuario_id" value="<?php echo empty($res['usuario_id']) ? '' : $res['usuario_id'] ?>" />
			<ul style="width:600px">
				<li>Nome:</li>
				<li><input type="text" name="usuario_nome" class="obrigatorio" id="usuario_nome" value="<?php echo empty($res['usuario_nome']) ? '' : $res['usuario_nome'] ?>" /></li>
			</ul><br clear="all" />
			
			<ul style="width:300px">
				<li>Login:</li>
				<li><input type="text" name="usuario_login" class="obrigatorio" id="usuario_login" value="<?php echo empty($res['usuario_login']) ? '' : $res['usuario_login'] ?>" /></li>
			</ul>
			<ul style="width:300px">
				<li>Senha:</li>
				<li><input type="password" name="usuario_senha" class="obrigatorio" id="usuario_senha" value="<?php echo empty($res['usuario_senha']) ? '' : $res['usuario_senha'] ?>" /></li>
			</ul><br clear="all" />
			
			<ul style="width:300px">
				<li>E-mail:</li>
				<li><input type="text" name="usuario_email" class="obrigatorio" id="usuario_email" value="<?php echo empty($res['usuario_email']) ? '' : $res['usuario_email'] ?>" /></li>
			</ul>
			<ul style="width:300px">
				<li>Avatar:</li>
				<li><input type="file" name="usuario_avatar_up" id="usuario_avatar_up" value="" /></li>
			</ul><br clear="all" />
			
			<ul style="width:300px">
				<li>Nível:</li>
				<li>
					<select id="usuario_nivel_id" name="usuario_nivel_id" class="obrigatorio">
						<option value="">Selecione um nivel</option>
						<?	foreach($aUsuarioNivel AS $v):?>
						<option value="<?=$v['usuario_nivel_id']?>"<?=($res['usuario_nivel_id']==$v['usuario_nivel_id']?' selected="selected"':'')?>><?=$v['usuario_nivel_titulo']?></option>
						<?	endforeach;?>
					</select>
				</li>
			</ul>
			<ul style="width:300px">
				<li>Status:</li>
				<li>
					<select id="usuario_status" name="usuario_status" class="obrigatorio">
						<option value="1"<?=($res['usuario_status']=='1'?' selected="selected"':'')?>>Ativo</option>
						<option value="0"<?=($res['usuario_status']=='0'?' selected="selected"':'')?>>Inativo</option>
					</select>
				</li>
			</ul><br clear="all" />
			<ul style="width:600px">
				<li>Avatar Cadastrado:</li>
				<li>
					<?	if(is_file("{$path_root_usuarioView}avatars{$DS}{$res['usuario_avatar']}")):?>
					<img src="../avatars/<?=$res['usuario_avatar']?>" border="0" alt="avatar" />
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
	include_once("{$path_root_usuarioView}admin{$DS}includes{$DS}footer.php");
?>