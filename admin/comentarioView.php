<?php
	$path_root_comentarioView = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_comentarioView = "{$path_root_comentarioView}{$DS}..{$DS}";
	include_once("{$path_root_comentarioView}admin{$DS}includes{$DS}header.php");
	include_once("{$path_root_comentarioView}admin{$DS}model{$DS}comentario.class.php");
	$objcomentario = new comentario();

	$session = $objcomentario->getSessions();
	if(isset($session['msgEdit'])&&trim($session['msgEdit'])!=''){
		echo "
			<script type=\"text/javascript\">
				newAlert('{$session['msgEdit']}');
			</script>
		";
	}
	$obj->unsetSession('msgEdit');

	//echo "<pre>" . print_r($_REQUEST,true) . "</pre>";

	$session = $objcomentario->setValues($_REQUEST);
	if(!empty($_REQUEST['comentario_id'])){
		$res = $objcomentario->getOne();
	}
	//echo "<pre>".print_r($res,true)."</pre>";
?>

<!-- js admin include -->
<script type="text/javascript" src="js/comentarioView.js"></script>

<style type="text/css">
	.contentValue{
		border: 1px solid #CDCDCD;
		background:#FFF;
		padding: 2px;
	}
	.comentValue{
		border: 1px solid #CDCDCD;
		background:#FFF;
		padding: 2px;
		height: 200px;
		width: 600px;
		overflow: auto;
	}
	
</style>

<div class="form-main">
	<div class="legend" >Ativação/Visualização do Comentário</div>
	<div class="forms cadastros">
		<form action="controller/comentario.controller.php?action=edit" method="post" id="formSalvar" enctype="multipart/form-data">
			<input type="hidden" name="comentario_id" id="comentario_id" value="<?php echo $res['comentario_id']; ?>" />
			<ul>
				<li>Titulo Post:</li>
				<li><b class="contentValue"><?=$res['post_titulo']?></b></li>
			</ul>
			<ul>
				<li>Nome do autor:</li>
				<li><b class="contentValue"><?=$res['comentario_autor']?></b></li>
			</ul>
			<ul>
				<li>Email do autor:</li>
				<li><b class="contentValue"><?=$res['comentario_email']?></b></li>
			</ul>
			<br clear="all" />
			<ul>
				<li>Data Criação do Comentario:</li>
				<li><b class="contentValue"><?=$objcomentario->dateDB2BR($res['comentario_dt_criacao'])?></b></li>
			</ul>
			<ul>
				<li>Dt/Hr Criação do Comentario:</li>
				<li><b class="contentValue"><?=$objcomentario->dateDB2BR($res['comentario_dtcomp_criacao'])?></b></li>
			</ul>
			<ul>
				<li>Data Ativação do Comentario:</li>
				<li><b class="contentValue"><?=$objcomentario->dateDB2BR($res['comentario_dt_alteracao'])?></b></li>
			</ul>
			<ul>
				<li>Dt/Hr Ativação do Comentario:</li>
				<li><b class="contentValue"><?=$objcomentario->dateDB2BR($res['comentario_dtcomp_alteracao'])?></b></li>
			</ul>
			<br clear="all" />
			<ul>
				<li>Comentario:</li>
				<li>
					<textarea class="comentValue"><?=$res['comentario_conteudo']?></textarea>
				</li>
			</ul>
			<br clear="all"/>
			<ul style="width:300px">
				<li>Status:</li>
				<li>
					<select id="comentario_status" name="comentario_status" class="obrigatorio">
						<option value="">Selecione um Status</option>
						<option value="1" <?=($res['comentario_status']=='1'?' selected="selected"':'')?>>Liberado</option>
						<option value="0" <?=($res['comentario_status']=='0'?' selected="selected"':'')?>>Não Liberado</option>
						<option value="2" <?=($res['comentario_status']=='2'?' selected="selected"':'')?>>Cancelado</option>
					</select>
				</li>
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
	include_once("{$path_root_comentarioView}admin{$DS}includes{$DS}footer.php");
?>