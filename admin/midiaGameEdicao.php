<?php
	$path_root_midiaGameView = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_midiaGameView = "{$path_root_midiaGameView}{$DS}..{$DS}";
	include_once("{$path_root_midiaGameView}admin{$DS}includes{$DS}header.php");
	include_once("{$path_root_midiaGameView}admin{$DS}model{$DS}midiaGame.class.php");
	$objMidiaGame = new midiaGame();
	
	$session = $objMidiaGame->getSessions();
	if(isset($session['msgEdit'])&&trim($session['msgEdit'])!=''){
		echo "
			<script type=\"text/javascript\">
				newAlert('{$session['msgEdit']}');
			</script>
		";
	}
	$obj->unsetSession('msgEdit');
	
	//echo "<pre>" . print_r($_REQUEST,true) . "</pre>";

	$session = $objMidiaGame->setValues($_REQUEST);
	if(!empty($_REQUEST['game_midia_id'])){
		$res = $objMidiaGame->getOne();
	}
?>

<!-- js admin include -->
<script type="text/javascript" src="js/midiaGameEdicao.js"></script>
<div class="form-main">
	<div class="legend" >Mídia de Games - <?php echo empty($res['game_midia_id']) ? 'Cadastro' : 'Edição' ?></div>
	<div class="forms cadastros">
		<form action="controller/midiaGame.controller.php?action=edit" method="post" id="formSalvar" enctype="multipart/form-data">
			<input type="hidden" name="game_midia_id" id="game_midia_id" value="<?php echo empty($res['game_midia_id']) ? '' : $res['game_midia_id'] ?>" />
			<ul style="width:600px">
				<li>Nome:</li>
				<li><input type="text" name="game_midia_nome" class="obrigatorio" id="game_midia_nome" value="<?php echo empty($res['game_midia_nome']) ? '' : $res['game_midia_nome'] ?>" /></li>
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
	include_once("{$path_root_midiaGameView}admin{$DS}includes{$DS}footer.php");
?>