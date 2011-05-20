<?php
	$path_root_publicidadeView = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_publicidadeView = "{$path_root_publicidadeView}{$DS}..{$DS}";
	include_once("{$path_root_publicidadeView}admin{$DS}includes{$DS}header.php");
	include_once("{$path_root_publicidadeView}admin{$DS}model{$DS}publicidade.class.php");
	$objPublicidade = new publicidade();

	$session = $objPublicidade->getSessions();
	if(isset($session['msgEdit'])&&trim($session['msgEdit'])!=''){
		echo "
			<script type=\"text/javascript\">
				newAlert('{$session['msgEdit']}');
			</script>
		";
	}
	$obj->unsetSession('msgEdit');


	$session = $objPublicidade->setValues($_REQUEST);
	if(!empty($_GET['publicidade_id'])){
		$res = $objPublicidade->getOne();
	}

	//echo "<pre>" . print_r($res,true) . "</pre>";

?>

<!-- js admin include -->
<script type="text/javascript" src="js/jquery.flash.js"></script>
<script type="text/javascript" src="js/jquery.mask.js"></script>
<script type="text/javascript" src="js/publicidadeEdicao.js"></script>
<script type="text/javascript" src="js/i18n/jquery.ui.datepicker-pt-BR.js"></script>
<div class="form-main">
	<div class="legend" >Publicidades - <?php echo empty($res['publicidade_id']) ? 'Cadastro' : 'Edição' ?></div>
	<div class="forms cadastros">
		<form action="controller/publicidade.controller.php?action=edit" method="POST" id="formSalvar" enctype="multipart/form-data">
			<input type="hidden" name="publicidade_id" id="publicidade_id" value="<?php echo empty($res['publicidade_id']) ? '' : $res['publicidade_id'] ?>" />

			<ul style="width:250px">
				<li>Tipo de Midia:</li>
				<li>
					<select id="publicidade_tipomedia" name="publicidade_tipomedia" class="obrigatorio">
						<option value="">Selecione uma tipo de midia</option>
						<option value="0" <?=($res['publicidade_tipomedia']=='0'?' selected="selected"':'')?>>Imagem</option>
						<option value="1" <?=($res['publicidade_tipomedia']=='1'?' selected="selected"':'')?>>Flash</option>
					</select>
				</li>
			</ul>
			
			<ul style="width:600px">
				<li>Arquivo:</li>
				<li>
					<input type="file" name="publicidade_arquivo" id="publicidade_arquivo" value="" />
				</li>
			</ul>
			<br clear="all" />

			<ul style="width:150px">
				<li>Data Criação:</li>
				<li><input readonly="yes" type="text" name="publicidade_dt_criacao" class="obrigatorio" id="publicidade_dt_criacao" value="<?php echo (empty($res['publicidade_dt_criacao']) && !isset($res['publicidade_dt_criacao'])) ? date('d/m/Y') : $objPublicidade->dateDB2BR($res['publicidade_dt_criacao']) ?>" /></li>
			</ul>
			<ul style="width:150px">
				<li>Dt/Hr Criação:</li>
				<li><input readonly="yes" type="text" name="publicidade_dtcomp_criacao" class="obrigatorio" id="publicidade_dtcomp_criacao" value="<?php echo empty($res['publicidade_dtcomp_criacao']) ? date('d/m/Y H:i:s') : $objPublicidade->dateDB2BRTime($res['publicidade_dtcomp_criacao']) ?>" /></li>
			</ul>

			<ul style="width:150px">
				<li>Data Ativação:</li>
				<li><input type="text" class="data" name="publicidade_dt_ativacao" id="publicidade_dt_ativacao" value="<?php echo empty($res['publicidade_dt_ativacao']) ? date("d/m/Y H:i:s") : $objPublicidade->dateDB2BR($res['publicidade_dt_ativacao']) ?>" /></li>
			</ul>
			<ul style="width:150px">
				<li>Data Desativação:</li>
				<li><input type="text" class="data" name="publicidade_dt_desativacao" id="publicidade_dt_desativacao" value="<?php echo empty($res['publicidade_dt_desativacao']) ? date("d/m/Y H:i:s",strtotime("1 WEEK")) : $objPublicidade->dateDB2BR($res['publicidade_dt_desativacao']) ?>" /></li>
			</ul>
			<?php if(!empty($res['publicidade_arquivo'])): ?>
			<br clear="all" />
			<ul style="width:600px">
				<li>Arquivo:</li>
				<li>
					<?	if($res['publicidade_tipomedia'] == 0):?>
					<img src="../publicidade/<?=$res['publicidade_arquivo']?>" border="0" alt="Publicidade" width="30%" height="30%"/>
					<?	else:?>
					<script type="text/javascript">
						$(document).ready(function(){
							$("#flash").flash(
								{ src: '../publicidade/<?=$res['publicidade_arquivo']?>' }
							)
						});
					</script>
					<div id="flash"></div>
					<?	endif;?>
				</li>
			</ul>
			<?php endif; ?>
		</form>
	</div>
	<div class="botoes">
		<button id="salvar">Salvar</button>
		<button id="limparCadastro">Limpar</button>
		<button id="voltar">Voltar</button>

	</div>
</div>
<?php
	include_once("{$path_root_publicidadeView}admin{$DS}includes{$DS}footer.php");
?>