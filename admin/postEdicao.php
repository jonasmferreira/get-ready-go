<?php
	$path_root_postView = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_postView = "{$path_root_postView}{$DS}..{$DS}";
	include_once("{$path_root_postView}admin{$DS}includes{$DS}header.php");
	include_once("{$path_root_postView}admin{$DS}model{$DS}post.class.php");
	$objPost = new post();
	$aUsuario = $objPost->getUsuario(false);
	$aCategoria = $objPost->getCategoria(false);
	
	$session = $objPost->getSessions();
	if(isset($session['msgEdit'])&&trim($session['msgEdit'])!=''){
		echo "
			<script type=\"text/javascript\">
				newAlert('{$session['msgEdit']}');
			</script>
		";
	}
	$obj->unsetSession('msgEdit');
	

	$session = $objPost->setValues($_REQUEST);
	if(!empty($_REQUEST)){
		$res = $objPost->getOne();
	}
	
	//echo "<pre>" . print_r($res,true) . "</pre>";
	
?>

<!-- js admin include -->
<script type="text/javascript" src="js/postEdicao.js"></script>
<div class="form-main">
	<div class="legend" ><?php echo empty($res['post_id']) ? 'Cadastro' : 'Edição' ?></div>
	<div class="forms cadastros">
		<form action="controller/post.controller.php?action=edit" method="post" id="formSalvar" enctype="multipart/form-data">
			<input type="hidden" name="post_id" id="post_id" value="<?php echo empty($res['post_id']) ? '' : $res['post_id'] ?>" />
			
			<ul style="width:250px">
				<li>Categoria:</li>
				<li>
					<select id="categoria_id" name="categoria_id" class="obrigatorio">
						<option value="">Selecione uma categoria</option>
						<?	foreach($aCategoria AS $v):?>
						<option value="<?=$v['categoria_id']?>"<?=($res['categoria_id']==$v['categoria_id']?' selected="selected"':'')?>><?=$v['categoria_nome']?></option>
						<?	endforeach;?>
					</select>
				</li>
			</ul>

			<ul style="width:200px">
				<li>Usuário:</li>
				<li>
					<select id="usuario_id" name="usuario_id" class="obrigatorio">
						<option value="">Selecione um usuário</option>
						<?	foreach($aUsuario AS $v):?>
						<option value="<?=($v['usuario_id'])?>" <?=($res['usuario_id']==$v['usuario_id']?' selected="selected"':'')?>><?=$v['usuario_nome_nivel']?></option>
						<?	endforeach;?>
					</select>
				</li>
			</ul>
			<ul style="width:100px">
				<li>Status:</li>
				<li>
					<select id="post_status" name="post_status" class="obrigatorio">
						<option value="1"<?=($res['post_status']=='1'?' selected="selected"':'')?>>Publicado</option>
						<option value="0"<?=($res['post_status']=='0'?' selected="selected"':'')?>>Não Publicado</option>
					</select>
				</li>
			</ul><br clear="all" />
			
			
			<ul style="width:600px">
				<li>Título:</li>
				<li><input type="text" name="post_titulo" class="obrigatorio" id="post_titulo" value="<?php echo empty($res['post_titulo']) ? '' : $res['post_titulo'] ?>" /></li>
			</ul><br clear="all" />

			<ul style="width:600px">
				<li>Palavras Chave:</li>
				<li><input type="text" name="post_palavra_chave" class="obrigatorio" id="post_palavra_chave" value="<?php echo empty($res['post_palavra_chave']) ? '' : $res['post_palavra_chave'] ?>" /></li>
			</ul>
<br clear="all" />

			<ul style="width:600px;">
				<li>Conteúdo:</li>
				<li><input type="textarea" height=300 name="post_conteudo" class="obrigatorio" id="post_conteudo" value="<?php echo empty($res['post_conteudo']) ? '' : $res['post_conteudo'] ?>" /></li>
			</ul><br clear="all" />

			<ul style="width:600px">
				<li>Thumb Home:</li>
				<li><input type="file" name="post_thumb_home" id="post_thumb_home" value="" /></li>
			</ul>
			<br clear="all" />
			
			<ul style="width:600px">
				<li>Thumb Cadastrado:</li>
				<li>
					<?	if(is_file("{$path_root_postView}posts{$DS}{$res['post_thumb_home']}")):?>
					<img src="../posts/<?=$res['post_thumb_home']?>" border="0" alt="thumb home" />
					<?	else:?>
					Nenhum Thumb
					<?	endif;?>
				</li>
			</ul>
			<br clear="all" />
			
			<ul style="width:600px">
				<li>Imagem Destaque:</li>
				<li><input type="file" name="post_imagem" id="post_imagem" value="" /></li>
			</ul>
			<br clear="all" />
			
			<ul style="width:600px">
				<li>Destaque Cadastrado:</li>
				<li>
					<?	if(is_file("{$path_root_postView}posts{$DS}{$res['post_imagem']}")):?>
					<img src="../posts/<?=$res['post_imagem']?>" border="0" alt="destaque" />
					<?	else:?>
					Nenhum Destaque
					<?	endif;?>
				</li>
			</ul>
			<br clear="all" />
			
			<ul style="width:150px">
				<li>Data Criação:</li>
				<li><input readonly="yes" type="text" name="post_dt_criacao" class="obrigatorio" id="post_dt_criacao" value="<?php echo empty($res['post_dt_criacao']) ? date('d/m/Y') : $res['post_dt_criacao'] ?>" /></li>
			</ul>
			<ul style="width:150px">
				<li>Dt/Hr Criação:</li>
				<li><input readonly="yes" type="text" name="post_dtcomp_criacao" class="obrigatorio" id="post_dtcomp_criacao" value="<?php echo empty($res['post_dtcomp_criacao']) ? date('d/m/Y H:i:s') : $res['post_dtcomp_criacao'] ?>" /></li>
			</ul>

			<ul style="width:150px">
				<li>Data Alteração:</li>
				<li><input readonly="yes" type="text" name="post_dt_alteracao" id="post_dt_alteracao" value="<?php echo empty($res['post_dt_alteracao']) ? '' : $res['post_dt_alteracao'] ?>" /></li>
			</ul>
			<ul style="width:150px">
				<li>Dt/Hr Alteração:</li>
				<li><input readonly="yes" type="text" name="post_dtcomp_alteracao" id="post_dtcomp_alteracao" value="<?php echo empty($res['post_dtcomp_alteracao']) ? '' : $res['post_dtcomp_alteracao'] ?>" /></li>
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
	include_once("{$path_root_postView}admin{$DS}includes{$DS}footer.php");
?>