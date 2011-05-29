<?php
	$path_root_gameView = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_gameView = "{$path_root_gameView}{$DS}..{$DS}";
	include_once("{$path_root_gameView}admin{$DS}includes{$DS}header.php");
	include_once("{$path_root_gameView}admin{$DS}model{$DS}game.class.php");
	$objGame = new game();
	$aTipo = $objGame->getTipoCombo(false);
	$aCategoria = $objGame->getCategoriaCombo(false);
	$aUsuario = $objGame->getUsuario(false);
	
	$session = $objGame->getSessions();
	if(isset($session['msgEdit'])&&trim($session['msgEdit'])!=''){
		echo "
			<script type=\"text/javascript\">
				newAlert('{$session['msgEdit']}');
			</script>
		";
	}
	$objGame->unsetSession('msgEdit');
	

	$session = $objGame->setValues($_REQUEST);
	if(!empty($_REQUEST['game_id'])){
		$res = $objGame->getOne();
	}
	
?>

<!-- js admin include -->
<script type="text/javascript" src="js/gameEdicao.js"></script>
<div class="form-main">
	<div class="legend" >Games - <?php echo empty($res['game_id']) ? 'Cadastro' : 'Edição' ?></div>
	<div class="forms cadastros">
		<form action="controller/game.controller.php?action=edit" method="post" id="formSalvar" enctype="multipart/form-data">
			<input type="hidden" name="game_id" id="game_id" value="<?php echo empty($res['game_id']) ? '' : $res['game_id'] ?>" />
			
			<ul style="width:200px">
				<li>Categoria:</li>
				<li>
					<select id="game_categoria_id" name="game_categoria_id" class="obrigatorio">
						<option value="">Selecione uma categoria</option>
						<?	foreach($aCategoria AS $v):?>
						<option value="<?=$v['game_categoria_id']?>"<?=($res['game_categoria_id']==$v['game_categoria_id']?' selected="selected"':'')?>><?=$v['game_categoria_nome']?></option>
						<?	endforeach;?>
					</select>
				</li>
			</ul>

			<ul style="width:200px">
				<li>Tipo:</li>
				<li>
					<select id="game_tipo_id" name="game_tipo_id" class="obrigatorio">
						<option value="">Selecione um tipo</option>
						<?	foreach($aTipo AS $v):?>
						<option value="<?=($v['game_tipo_id'])?>" <?=($res['game_tipo_id']==$v['game_tipo_id']?' selected="selected"':'')?>><?=$v['game_tipo_nome']?></option>
						<?	endforeach;?>
					</select>
				</li>
			</ul>
			<ul style="width:200px">
				<li>Usuário:</li>
				<li>
					<select id="usuario_id" name="usuario_id" class="obrigatorio">
						<option value="">Selecione um usuário</option>
						<?	$outro = true;
							foreach($aUsuario AS $v):
								if($res['game_criador_nome']==$v['usuario_nome_nivel']){
									$outro = false;
								}
						?>
						<option value="<?=($v['usuario_id'])?>" <?=($res['game_criador_nome']==$v['usuario_nome_nivel']?' selected="selected"':'')?>><?=$v['usuario_nome_nivel']?></option>
						<?	endforeach;?>
						<option value="outro" <?=($outro===true&&!empty($res['game_id'])?' selected="selected"':'')?>>Outro</option>
					</select>
				</li>
			</ul><br clear="all" />
			<ul style="width:600px">
				<li>Criador:</li>
				<li><input type="text" name="game_criador_nome" class="obrigatorio" id="game_criador_nome" value="<?php echo empty($res['game_criador_nome']) ? '' : $res['game_criador_nome'] ?>" /></li>
			</ul><br clear="all" />
			<ul style="width:600px">
				<li>Título:</li>
				<li><input type="text" name="game_titulo" class="obrigatorio" id="game_titulo" value="<?php echo empty($res['game_titulo']) ? '' : $res['game_titulo'] ?>" /></li>
			</ul><br clear="all" />

			<ul style="width:600px;">
				<li>Conteúdo:</li>
				<li><textarea height="300" width="600" name="game_descricao" class="obrigatorio" id="game_descricao"><?php echo empty($res['game_descricao']) ? '' : $res['game_descricao'] ?></textarea></li>
			</ul><br clear="all" />

			<ul style="width:600px">
				<li>Thumb:</li>
				<li><input type="file" name="game_thumb" id="game_thumb" value="" /></li>
			</ul>
			<br clear="all" />
			
			<ul style="width:600px">
				<li>Thumb Cadastrado:</li>
				<li>
					<?	if(is_file("{$path_root_gameView}games{$DS}{$res['game_thumb']}")):?>
					<img src="../games/<?=$res['game_thumb']?>" border="0" alt="thumb" />
					<?	else:?>
					Nenhum Thumb
					<?	endif;?>
				</li>
			</ul>
			<br clear="all" />

			
			<ul style="width:600px">
				<li>Imagem Destaque:</li>
				<li><input type="file" name="game_imagem_destaque" id="game_imagem_destaque" value="" /></li>
			</ul>
			<br clear="all" />
			
			<ul style="width:600px">
				<li>Imagem Destaque Cadastrado:</li>
				<li>
					<?	if(is_file("{$path_root_gameView}games{$DS}{$res['game_imagem_destaque']}")):?>
					<img src="../games/<?=$res['game_imagem_destaque']?>" border="0" alt="Destaque" />
					<?	else:?>
					Nenhum Thumb de Destaque
					<?	endif;?>
				</li>
			</ul>
			<br clear="all" />
			<ul style="width:600px">
				<li>Link:</li>
				<li><input type="text" name="game_link" class="obrigatorio" id="game_link" value="<?php echo empty($res['game_link']) ? '' : $res['game_link'] ?>" /></li>
			</ul><br clear="all" />
			
		</form>
	</div>
	<div class="botoes">
		<button id="salvar">Salvar</button>
		<button id="limparCadastro">Limpar</button>
		<button id="voltar">Voltar</button>

	</div>
</div>
<?php
	include_once("{$path_root_gameView}admin{$DS}includes{$DS}footer.php");
?>