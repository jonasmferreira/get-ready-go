<?php
	$path_root_enqueteView = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_enqueteView = "{$path_root_enqueteView}{$DS}..{$DS}";
	include_once("{$path_root_enqueteView}admin{$DS}includes{$DS}header.php");
	include_once("{$path_root_enqueteView}admin{$DS}model{$DS}enquete.class.php");
	$objEnquete = new enquete();
	
	$session = $objEnquete->getSessions();
	if(isset($session['msgEdit'])&&trim($session['msgEdit'])!=''){
		echo "
			<script type=\"text/javascript\">
				newAlert('{$session['msgEdit']}');
			</script>
		";
	}
	$objEnquete->unsetSession('msgEdit');

	$session = $objEnquete->setValues($_REQUEST);
	if(!empty($_REQUEST['enquete_id'])){
		$res = $objEnquete->getOne();
		$resOp = $objEnquete->opcaoEnquete($res['enquete_id']);
	}
	
?>

<!-- js admin include -->
<script type="text/javascript" src="js/enqueteEdicao.js"></script>
<div class="form-main">
	<div class="legend" >Enquetes - <?php echo empty($res['enquete_id']) ? 'Cadastro' : 'Edição' ?></div>
	<div class="forms cadastros">
		<form action="controller/enquete.controller.php?action=edit" method="post" id="formSalvar" enctype="multipart/form-data">
			<input type="hidden" name="enquete_id" id="enquete_id" value="<?php echo empty($res['enquete_id']) ? '' : $res['enquete_id'] ?>" />
			
			
			<ul style="width:600px">
				<li>Título:</li>
				<li><input type="text" name="enquete_titulo" class="obrigatorio" id="enquete_titulo" value="<?php echo empty($res['enquete_titulo']) ? '' : $res['enquete_titulo'] ?>" /></li>
			</ul><br clear="all" />
			
			<ul style="width:100px">
				<li>Status:</li>
				<li>
					<select id="enquete_status" name="enquete_status" class="obrigatorio">
						<option value="1"<?=($res['enquete_status']=='1'?' selected="selected"':'')?>>Ativo</option>
						<option value="0"<?=($res['enquete_status']=='0'?' selected="selected"':'')?>>Inativo</option>
					</select>
				</li>
			</ul><br clear="all" />
			
			
			<ul style="width:150px">
				<li>Data Criação:</li>
				<li><input readonly="yes" type="text" name="enquete_dt_criacao" class="obrigatorio" id="enquete_dt_criacao" value="<?php echo empty($res['enquete_dt_criacao']) ? date('d/m/Y') : $objEnquete->dateDB2BR($res['enquete_dt_criacao']) ?>" /></li>
			</ul>
			<ul style="width:150px">
				<li>Dt/Hr Criação:</li>
				<li><input readonly="yes" type="text" name="enquete_dtcomp_criacao" class="obrigatorio" id="enquete_dtcomp_criacao" value="<?php echo empty($res['enquete_dtcomp_criacao']) ? date('d/m/Y H:i:s') : $objEnquete->dateDB2BRTime($res['enquete_dtcomp_criacao']) ?>" /></li>
			</ul>

			<ul style="width:150px">
				<li>Data Alteração:</li>
				<li><input readonly="yes" type="text" name="enquete_dt_alteracao" id="enquete_dt_alteracao" value="<?php echo empty($res['enquete_dt_alteracao']) ? '' : $objEnquete->dateDB2BR($res['enquete_dt_alteracao']) ?>" /></li>
			</ul>
			<ul style="width:150px">
				<li>Dt/Hr Alteração:</li>
				<li><input readonly="yes" type="text" name="enquete_dtcomp_alteracao" id="enquete_dtcomp_alteracao" value="<?php echo empty($res['enquete_dtcomp_alteracao']) ? '' : $objEnquete->dateDB2BRTime($res['enquete_dtcomp_alteracao']) ?>" /></li>
			</ul><br clear="all" /><br clear="all" />
			
			<table id="rounded-corner" style="width:80%">
				<caption>Opções da Enquete</caption>
				<thead>
					<tr>
						<th style="width:25px" class="rounded-company"><div class="icon-add" style="cursor:pointer" id="addOpcao">&nbsp</div></th>
						<th class="rounded-q1">Nome</th>
						<th class="rounded-q4">Qtde Votos</th>
					</tr>
				</thead>
				<tbody>
					<?	if(is_array($resOp)&&count($resOp) > 0):
							foreach($resOp AS $v):
					?>
					<tr>
						<td>
							<div class="icon-cancel delOpcao">&nbsp;</div>
							<input type="hidden" name="enquete_opcao_id[]" value="<?=$v['enquete_opcao_id']?>" />
						</td>
						<td><input type="text" name="enquete_opcao_titulo[]" value="<?=$v['enquete_opcao_titulo']?>" /></td>
						<td><?=$v['resultado']?></td>
					</tr>
					<?		endforeach;
						endif;?>
				</tbody>
			</table>
		</form>
	</div>
	<div class="botoes">
		<button id="salvar">Salvar</button>
		<button id="limparCadastro">Limpar</button>
		<button id="voltar">Voltar</button>

	</div>
</div>
<?php
	include_once("{$path_root_enqueteView}admin{$DS}includes{$DS}footer.php");
?>