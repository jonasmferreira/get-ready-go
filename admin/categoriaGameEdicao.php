<?php
	$path_root_categoriaGameView = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_categoriaGameView = "{$path_root_categoriaGameView}{$DS}..{$DS}";
	include_once("{$path_root_categoriaGameView}admin{$DS}includes{$DS}header.php");
	include_once("{$path_root_categoriaGameView}admin{$DS}model{$DS}categoriaGame.class.php");
	$objCategoriaGame = new categoriaGame();
	
	$session = $objCategoriaGame->getSessions();
	if(isset($session['msgEdit'])&&trim($session['msgEdit'])!=''){
		echo "
			<script type=\"text/javascript\">
				newAlert('{$session['msgEdit']}');
			</script>
		";
	}
	$obj->unsetSession('msgEdit');
	
	//echo "<pre>" . print_r($_REQUEST,true) . "</pre>";

	$session = $objCategoriaGame->setValues($_REQUEST);
	if(!empty($_REQUEST['game_categoria_id'])){
		$res = $objCategoriaGame->getOne();
	}
?>

<!-- js admin include -->
<script type="text/javascript" src="js/categoriaGameEdicao.js"></script>
<div class="form-main">
	<div class="legend" >Categoria de Games - <?php echo empty($res['game_categoria_id']) ? 'Cadastro' : 'Edição' ?></div>
	<div class="forms cadastros">
		<form action="controller/categoriaGame.controller.php?action=edit" method="post" id="formSalvar" enctype="multipart/form-data">
			<input type="hidden" name="game_categoria_id" id="game_categoria_id" value="<?php echo empty($res['game_categoria_id']) ? '' : $res['game_categoria_id'] ?>" />
			<ul style="width:600px">
				<li>Nome:</li>
				<li><input type="text" name="game_categoria_nome" class="obrigatorio" id="game_categoria_nome" value="<?php echo empty($res['game_categoria_nome']) ? '' : $res['game_categoria_nome'] ?>" /></li>
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
	include_once("{$path_root_categoriaGameView}admin{$DS}includes{$DS}footer.php");
?>