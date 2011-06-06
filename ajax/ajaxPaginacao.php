<?php
	$path_root_postController = dirname(__FILE__);
	$DS = DIRECTORY_SEPARATOR;
	$path_root_postController = "{$path_root_postController}{$DS}..{$DS}";
	switch($_REQUEST['action']){
		case 'listagem':
			require_once "{$path_root_postController}class/home.class.php";
			$obj = new home();
			$obj->setCategoria_id($_POST['categoria_id']);
			$obj->setLimitMax(3);
			$obj->setLimitStart($_POST['limit']);
			$aLista = $obj->getLastPost();
?>
			<div id="listagem_<?php echo $_POST['limit']; ?>">
				<?php foreach($aLista as $k => $v){ ?>
						<div id="newsItem">
							<div id="newsImg">
								<a href="@LINKABSOLUTO@<?php echo "{$v['linkDetalhe']}"; ?>">
									<img src="@LINKABSOLUTO@<?php echo "posts/{$v['post_thumb_home']}"; ?>" width="150px" height="80px" alt="<?php echo $v['post_titulo']; ?>" />
								</a>
							</div>
							<div id="newsInfo">
								<h3>
									<a href="@LINKABSOLUTO@<?php echo "{$v['linkDetalhe']}"; ?>">
										<?php echo $v['post_titulo']; ?>
									</a>
								</h3>
								<p class="data"><?php echo $v['post_dt_criacao']; ?></p>
								<p><?php echo $obj->cutHTML($v['post_conteudo'],120); ?></p>
								<p class="comments"><img src="@LINKABSOLUTO@imgs/icon_comentario.gif" align="absmiddle" /> <a href="#"><?php echo $v['qtdComentario']; ?> comentários</a></p>
							</div>
						</div>
				<?php } ?>
			</div>
<?
		break;
		case 'getCategoria':
			$aJson = array();
			$aJson = $obj->getCategoria();
			echo json_encode($aJson);
		break;
		case 'getUsuario':
			$aJson = array();
			$aJson = $obj->getUsuario();
			echo json_encode($aJson);
		break;
		case 'getGaleria':
			$aJson = array();
			$aJson = $obj->getGaleria();
			echo json_encode($aJson);
		break;
	}


?>
