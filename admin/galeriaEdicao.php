<?php
	$path_root_galeriaView = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_galeriaView = "{$path_root_galeriaView}{$DS}..{$DS}";
	include_once("{$path_root_galeriaView}admin{$DS}includes{$DS}header.php");
	include_once("{$path_root_galeriaView}admin{$DS}model{$DS}galeria.class.php");
	$objGaleria = new galeria();
	
	$session = $objGaleria->getSessions();
	if(isset($session['msgEdit'])&&trim($session['msgEdit'])!=''){
		echo "
			<script type=\"text/javascript\">
				newAlert('{$session['msgEdit']}');
			</script>
		";
	}
	$objGaleria->unsetSession('msgEdit');

	$session = $objGaleria->setValues($_REQUEST);
	if(!empty($_REQUEST['galeria_id'])){
		$res = $objGaleria->getOne();
		$resImg = $objGaleria->getListaImagens($res['galeria_id']);
	}
	
?>

<!-- js admin include -->
<script type="text/javascript" src="js/galeriaEdicao.js"></script>
<div class="form-main">
	<div class="legend" >Galerias - <?php echo empty($res['galeria_id']) ? 'Cadastro' : 'Edição' ?></div>
	<div class="forms cadastros">
		<form action="controller/galeria.controller.php?action=edit" method="post" id="formSalvar" enctype="multipart/form-data">
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
				<li><input readonly="yes" type="text" name="galeria_dt_criacao" class="obrigatorio" id="galeria_dt_criacao" value="<?php echo empty($res['galeria_dt_criacao']) ? date('d/m/Y') : $objGaleria->dateDB2BR($res['galeria_dt_criacao']) ?>" /></li>
			</ul>
			<ul style="width:150px">
				<li>Dt/Hr Criação:</li>
				<li><input readonly="yes" type="text" name="galeria_dtcomp_criacao" class="obrigatorio" id="galeria_dtcomp_criacao" value="<?php echo empty($res['galeria_dtcomp_criacao']) ? date('d/m/Y H:i:s') : $objGaleria->dateDB2BRTime($res['galeria_dtcomp_criacao']) ?>" /></li>
			</ul>

			<ul style="width:150px">
				<li>Data Alteração:</li>
				<li><input readonly="yes" type="text" name="galeria_dt_alteracao" id="galeria_dt_alteracao" value="<?php echo empty($res['galeria_dt_alteracao']) ? '' : $objGaleria->dateDB2BR($res['galeria_dt_alteracao']) ?>" /></li>
			</ul>
			<ul style="width:150px">
				<li>Dt/Hr Alteração:</li>
				<li><input readonly="yes" type="text" name="galeria_dtcomp_alteracao" id="galeria_dtcomp_alteracao" value="<?php echo empty($res['galeria_dtcomp_alteracao']) ? '' : $objGaleria->dateDB2BRTime($res['galeria_dtcomp_alteracao']) ?>" /></li>
			</ul><br clear="all" /><br clear="all" />
			
			<table id="rounded-corner" style="width:80%">
				<caption>Imagens da Galeria</caption>
				<thead>
					<tr>
						<th style="width:25px" class="rounded-company"><div class="icon-add" style="cursor:pointer" id="addImage">&nbsp</div></th>
						<th class="rounded-q1">Nome</th>
						<th class="rounded-q2">Thumb</th>
						<th class="rounded-q4">Imagem</th>
					</tr>
				</thead>
				<tbody>
					<?	if(is_array($resImg)&&count($resImg) > 0):
							foreach($resImg AS $v):
					?>
					<tr>
						<td>
							<div class="icon-cancel delImage">&nbsp;</div>
							<input type="hidden" name="imagem_galeria_id[]" value="<?=$v['imagem_galeria_id']?>" />
						</td>
						<td><input type="text" name="imagem_galeria_titulo[]" value="<?=$v['imagem_galeria_titulo']?>" /></td>
						<td>
							<?	if(is_file("{$path_root_galeriaView}galerias{$DS}galeria_{$v['galeria_id']}{$DS}thumbs{$DS}{$v['imagem_galeria_thumb']}")):
									list($widthThumb, $heightThumb, $typeThumb, $attrThumb) = getimagesize("{$path_root_galeriaView}galerias{$DS}galeria_{$v['galeria_id']}{$DS}thumbs{$DS}{$v['imagem_galeria_thumb']}");
									$widthThumb = ($widthThumb > 150)?"20%":$widthThumb;
									$heightThumb = ($heightThumb > 150)?"20%":$heightThumb;
							?>
							<img src="../galerias/galeria_<?=$v['galeria_id']."/thumbs/{$v['imagem_galeria_thumb']}"?>" alt="thumb: <?=$v['imagem_galeria_titulo']?>" border="0" width="<?=$widthThumb?>" height="<?=$heightThumb?>" />
							<br clear="all" />
							<?	endif;?>
							<input type="file" name="imagem_galeria_thumb[]" />
						</td>
						<td>
							<?	if(is_file("{$path_root_galeriaView}galerias{$DS}galeria_{$v['galeria_id']}{$DS}{$v['imagem_galeria_imagem']}")):
									list($widthImg, $heightImg, $typeImg, $attrImg) = getimagesize("{$path_root_galeriaView}galerias{$DS}galeria_{$v['galeria_id']}{$DS}{$v['imagem_galeria_imagem']}");
									$widthImg = ($widthImg > 150)?"20%":$widthImg;
									$heightImg = ($heightImg > 150)?"20%":$heightImg;
							?>
							<img src="../galerias/galeria_<?=$v['galeria_id']."/{$v['imagem_galeria_imagem']}"?>" alt="imagem: <?=$v['imagem_galeria_titulo']?>" border="0" width="<?=$widthImg?>" height="<?=$heightImg?>" />
							<br clear="all" />
							<?	endif;?>
							<input type="file" name="imagem_galeria_imagem[]" />
						</td>
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
	include_once("{$path_root_galeriaView}admin{$DS}includes{$DS}footer.php");
?>