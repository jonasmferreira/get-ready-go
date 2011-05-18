<?php
	$path_root_galeriaView = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_galeriaView = "{$path_root_galeriaView}{$DS}..{$DS}";
	include_once("{$path_root_galeriaView}admin{$DS}includes{$DS}header.php");
	include_once("{$path_root_galeriaView}admin{$DS}model{$DS}galeria.class.php");
	$objPost = new galeria();
	
	$session = $objPost->getSessions();
	if(isset($session['msgEdit'])&&trim($session['msgEdit'])!=''){
		echo "
			<script type=\"text/javascript\">
				newAlert('{$session['msgEdit']}');
			</script>
		";
	}
	$objPost->unsetSession('msgEdit');

	$session = $objPost->setValues($_REQUEST);
	if(!empty($_REQUEST)){
		$res = $objPost->getOne();
	}
	
?>

<!-- js admin include -->
<script type="text/javascript" src="js/galeriaEdicao.js"></script>
<div class="form-main">
	<div class="legend" >Galerias - <?php echo empty($res['galeria_id']) ? 'Cadastro' : 'Edição' ?></div>
	<div class="forms cadastros">
		<form action="controller/galeria.controller.php?action=edit" method="galeria" id="formSalvar" enctype="multipart/form-data">
			<input type="hidden" name="galeria_id" id="galeria_id" value="<?php echo empty($res['galeria_id']) ? '' : $res['galeria_id'] ?>" />
			
			
			<ul style="width:600px">
				<li>Título:</li>
				<li><input type="text" name="galeria_titulo" class="obrigatorio" id="galeria_titulo" value="<?php echo empty($res['galeria_titulo']) ? '' : $res['galeria_titulo'] ?>" /></li>
			</ul><br clear="all" />
			
			<ul style="width:100px">
				<li>Status:</li>
				<li>
					<select id="galeria_status" name="galeria_status" class="obrigatorio">
						<option value="1"<?=($res['galeria_status']=='1'?' selected="selected"':'')?>>Ativo</option>
						<option value="0"<?=($res['galeria_status']=='0'?' selected="selected"':'')?>>Inativo</option>
					</select>
				</li>
			</ul><br clear="all" />
			
			
			<ul style="width:150px">
				<li>Data Criação:</li>
				<li><input readonly="yes" type="text" name="galeria_dt_criacao" class="obrigatorio" id="galeria_dt_criacao" value="<?php echo empty($res['galeria_dt_criacao']) ? date('d/m/Y') : $res['galeria_dt_criacao'] ?>" /></li>
			</ul>
			<ul style="width:150px">
				<li>Dt/Hr Criação:</li>
				<li><input readonly="yes" type="text" name="galeria_dtcomp_criacao" class="obrigatorio" id="galeria_dtcomp_criacao" value="<?php echo empty($res['galeria_dtcomp_criacao']) ? date('d/m/Y H:i:s') : $res['galeria_dtcomp_criacao'] ?>" /></li>
			</ul>

			<ul style="width:150px">
				<li>Data Alteração:</li>
				<li><input readonly="yes" type="text" name="galeria_dt_alteracao" id="galeria_dt_alteracao" value="<?php echo empty($res['galeria_dt_alteracao']) ? '' : $res['galeria_dt_alteracao'] ?>" /></li>
			</ul>
			<ul style="width:150px">
				<li>Dt/Hr Alteração:</li>
				<li><input readonly="yes" type="text" name="galeria_dtcomp_alteracao" id="galeria_dtcomp_alteracao" value="<?php echo empty($res['galeria_dtcomp_alteracao']) ? '' : $res['galeria_dtcomp_alteracao'] ?>" /></li>
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
	include_once("{$path_root_galeriaView}admin{$DS}includes{$DS}footer.php");
?>