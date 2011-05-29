<?php
	$path_root_tipoGameView = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_tipoGameView = "{$path_root_tipoGameView}{$DS}..{$DS}";
	include_once("{$path_root_tipoGameView}admin{$DS}includes{$DS}header.php");
	include_once("{$path_root_tipoGameView}admin{$DS}model{$DS}tipoGame.class.php");
	$objTipoGame = new tipoGame();
	
	$session = $objTipoGame->getSessions();
	if(isset($session['msgEdit'])&&trim($session['msgEdit'])!=''){
		echo "
			<script type=\"text/javascript\">
				newAlert('{$session['msgEdit']}');
			</script>
		";
	}
	$obj->unsetSession('msgEdit');
	
	//echo "<pre>" . print_r($_REQUEST,true) . "</pre>";

	$session = $objTipoGame->setValues($_REQUEST);
	if(!empty($_REQUEST['game_tipo_id'])){
		$res = $objTipoGame->getOne();
	}
?>

<!-- js admin include -->
<script type="text/javascript" src="js/tipoGameEdicao.js"></script>
<div class="form-main">
	<div class="legend" >Tipo de Games - <?php echo empty($res['game_tipo_id']) ? 'Cadastro' : 'Edição' ?></div>
	<div class="forms cadastros">
		<form action="controller/tipoGame.controller.php?action=edit" method="post" id="formSalvar" enctype="multipart/form-data">
			<input type="hidden" name="game_tipo_id" id="game_tipo_id" value="<?php echo empty($res['game_tipo_id']) ? '' : $res['game_tipo_id'] ?>" />
			<ul style="width:600px">
				<li>Nome:</li>
				<li><input type="text" name="game_tipo_nome" class="obrigatorio" id="game_tipo_nome" value="<?php echo empty($res['game_tipo_nome']) ? '' : $res['game_tipo_nome'] ?>" /></li>
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
	include_once("{$path_root_tipoGameView}admin{$DS}includes{$DS}footer.php");
?>