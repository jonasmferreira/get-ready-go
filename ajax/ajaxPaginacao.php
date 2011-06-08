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
		case 'comentarios':
			require_once "{$path_root_postController}class/noticia.class.php";
			$obj = new noticia();
			$obj->setPost_id($_POST['post_id']);
			$obj->setLimitMax(3);
			$obj->setLimitStart($_POST['limit']);
			$aComentario = $obj->comentarioPost();
?>
			<div id="listagem_<?php echo $_POST['limit']; ?>">
				<?php foreach($aComentario as $k => $v){ ?>
					<table class="comentario" cellspacing="0" cellpadding="5">
						<tr>
							<td align="center" valign="top">
								<?php if($v['usuario_avatar']==''){ ?>
								<img src="@LINKABSOLUTO@imgs/avatares/1.jpg" class="avatar" />
								<?php }else{ ?>
								<img src="<?php echo "@LINKABSOLUTO@avatars/{$v['usuario_avatar']}" ?>" class="avatar" />
								<?php } ?>
								<!--p style="font-size:14px; font-weight: bold">15<p>
								<a href="#"><img src="imgs/pos.gif" /></a>
								<a href="#"><img src="imgs/neg.gif" /></a-->
								<!-- Avaliação de comentário só para usuários cadastrados -->
							</td>
							<td valign="top">
								<p><a href="#"><strong><?php echo $v['comentario_autor']; ?></strong></a></p>
								<p class="data">Em 11 de Março de 2011, às 17:35</p>
								<p>
									<?php echo $obj->tagToEmoticon($v['comentario_conteudo']); ?>
								</p>
							</td>
						</tr>
					</table>
				<?php } ?>
			</div>
<?php
		break;
	}


?>
