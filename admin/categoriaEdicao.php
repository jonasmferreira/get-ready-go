<?php
	$path_root_categoriaView = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_categoriaView = "{$path_root_categoriaView}{$DS}..{$DS}";
	include_once("{$path_root_categoriaView}admin{$DS}includes{$DS}header.php");
	include_once("{$path_root_categoriaView}admin{$DS}model{$DS}categoria.class.php");
	$objCategoria = new categoria();
	
	$session = $objCategoria->getSessions();
	if(isset($session['msgEdit'])&&trim($session['msgEdit'])!=''){
		echo "
			<script type=\"text/javascript\">
				newAlert('{$session['msgEdit']}');
			</script>
		";
	}
	$obj->unsetSession('msgEdit');
	
	//echo "<pre>" . print_r($_REQUEST,true) . "</pre>";

	$session = $objCategoria->setValues($_REQUEST);
	if(!empty($_REQUEST['categoria_id'])){
		$res = $objCategoria->getOne();
	}
?>

<!-- js admin include -->
<script type="text/javascript" src="js/categoriaEdicao.js"></script>
<div class="form-main">
	<div class="legend" ><?php echo empty($res['categoria_id']) ? 'Cadastro' : 'Edição' ?></div>
	<div class="forms cadastros">
		<form action="controller/categoria.controller.php?action=edit" method="post" id="formSalvar" enctype="multipart/form-data">
			<input type="hidden" name="categoria_id" id="categoria_id" value="<?php echo empty($res['categoria_id']) ? '' : $res['categoria_id'] ?>" />
			<ul style="width:600px">
				<li>Nome:</li>
				<li><input type="text" name="categoria_nome" class="obrigatorio" id="categoria_nome" value="<?php echo empty($res['categoria_nome']) ? '' : $res['categoria_nome'] ?>" /></li>
			</ul><br clear="all" />
			
			<ul style="width:300px">
				<li>Destaque na home:</li>
				<li>
					<select id="categoria_destaque_home" name="categoria_destaque_home" class="obrigatorio">
						<option value="1"<?=($res['categoria_destaque_home']=='1'?' selected="selected"':'')?>>Sim</option>
						<option value="0"<?=($res['categoria_destaque_home']=='0'?' selected="selected"':'')?>>Não</option>
					</select>
				</li>
			</ul>
			
			<ul style="width:300px">
				<li>Galeria:</li>
				<li>
					<select id="categoria_galeria" name="categoria_galeria" class="obrigatorio">
						<option value="1"<?=($res['categoria_galeria']=='1'?' selected="selected"':'')?>>Sim</option>
						<option value="0"<?=($res['categoria_galeria']=='0'?' selected="selected"':'')?>>Não</option>
					</select>
				</li>
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
	include_once("{$path_root_categoriaView}admin{$DS}includes{$DS}footer.php");
?>