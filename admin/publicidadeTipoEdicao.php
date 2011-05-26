<?php
	$path_root_publicidadeTipoView = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_publicidadeTipoView = "{$path_root_publicidadeTipoView}{$DS}..{$DS}";
	include_once("{$path_root_publicidadeTipoView}admin{$DS}includes{$DS}header.php");
	include_once("{$path_root_publicidadeTipoView}admin{$DS}model{$DS}publicidadeTipo.class.php");
	$objPublicidadeTipo = new publicidadeTipo();

	$session = $objPublicidadeTipo->getSessions();
	if(isset($session['msgEdit'])&&trim($session['msgEdit'])!=''){
		echo "
			<script type=\"text/javascript\">
				newAlert('{$session['msgEdit']}');
			</script>
		";
	}
	$obj->unsetSession('msgEdit');

	//echo "<pre>" . print_r($_REQUEST,true) . "</pre>";

	$session = $objPublicidadeTipo->setValues($_REQUEST);
	if(!empty($_REQUEST['publicidade_tipo_id'])){
		$res = $objPublicidadeTipo->getOne();
	}
?>

<!-- js admin include -->
<script type="text/javascript" src="js/publicidadeTipoEdicao.js"></script>
<div class="form-main">
	<div class="legend" ><?php echo empty($res['publicidade_tipo_id']) ? 'Cadastro' : 'Edição' ?></div>
	<div class="forms cadastros">
		<form action="controller/publicidadeTipo.controller.php?action=edit" method="post" id="formSalvar" enctype="multipart/form-data">
			<input type="hidden" name="publicidade_tipo_id" id="publicidade_tipo_id" value="<?php echo empty($res['publicidade_tipo_id']) ? '' : $res['publicidade_tipo_id'] ?>" />
			<ul style="width:600px">
				<li>Titulo:</li>
				<li><input type="text" name="publicidade_tipo_titulo" class="obrigatorio" id="publicidade_tipo_titulo" value="<?php echo empty($res['publicidade_tipo_titulo']) ? '' : $res['publicidade_tipo_titulo'] ?>" maxlength="244" /></li>
			</ul>
			<br clear="all" />
			<ul style="width:150px">
				<li>Largura(px):</li>
				<li><input type="text" name="publicidade_tipo_largura" class="obrigatorio somenteNumero" id="publicidade_tipo_largura" value="<?php echo empty($res['publicidade_tipo_largura']) ? '' : $res['publicidade_tipo_largura'] ?>" maxlength="10" /></li>
			</ul>
			<ul style="width:150px">
				<li>Altura(px):</li>
				<li><input type="text" name="publicidade_tipo_altura" class="obrigatorio somenteNumero" id="publicidade_tipo_altura" value="<?php echo empty($res['publicidade_tipo_altura']) ? '' : $res['publicidade_tipo_altura'] ?>" maxlength="10" /></li>
			</ul>
			<br clear="all" />
			<ul style="width:150px">
				<li>Data Criação:</li>
				<li><input readonly="yes" type="text" name="publicidade_tipo_dt_criacao" id="publicidade_tipo_dt_criacao" value="<?php echo (empty($res['publicidade_tipo_dt_criacao']) && !isset($res['publicidade_tipo_dt_criacao'])) ? date('d/m/Y') : $objPublicidadeTipo->dateDB2BR($res['publicidade_tipo_dt_criacao']) ?>" /></li>
			</ul>
			<ul style="width:150px">
				<li>Dt/Hr Criação:</li>
				<li><input readonly="yes" type="text" name="publicidade_tipo_dtcomp_criacao" id="publicidade_tipo_dtcomp_criacao" value="<?php echo empty($res['publicidade_tipo_dtcomp_criacao']) ? date('d/m/Y H:i:s') : $objPublicidadeTipo->dateDB2BRTime($res['publicidade_tipo_dtcomp_criacao']) ?>" /></li>
			</ul>
			<br clear="all" />
			<ul style="width:150px">
				<li>Data Alteração:</li>
				<li><input readonly="yes" type="text" name="publicidade_tipo_dt_alteracao" id="publicidade_tipo_dt_alteracao" value="<?php echo (empty($res['publicidade_tipo_dt_alteracao']) && !isset($res['publicidade_tipo_dt_alteracao'])) ? '' : $objPublicidadeTipo->dateDB2BR($res['publicidade_tipo_dt_alteracao']) ?>" /></li>
			</ul>
			<ul style="width:150px">
				<li>Dt/Hr Alteração:</li>
				<li><input readonly="yes" type="text" name="publicidade_tipo_dtcomp_criacao" id="publicidade_tipo_dtcomp_criacao" value="<?php echo empty($res['publicidade_tipo_dt_alteracao']) ? '' : $objPublicidadeTipo->dateDB2BRTime($res['publicidade_tipo_dt_alteracao']) ?>" /></li>
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
	include_once("{$path_root_publicidadeTipoView}admin{$DS}includes{$DS}footer.php");
?>