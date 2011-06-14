<?php
	include_once 'includes/cabecalho.php';
	include_once 'includes/header.php';
	require_once 'class/noticia.class.php';
	require_once 'class/home.class.php';


	$obj = new noticia();
	$obj->setValues($_GET);
	$obj->savePageView();
	$obj->setPost_id($_GET['post_id']);
	$aNoticia = $obj->getOne();
	$aGaleria = $obj->galeriaPost();
	$obj->setLimitMax(12);
	$obj->setLimitStart(0);
	$aComentario = $obj->comentarioPost();
	$obj->setLimitMax(null);
	$obj->setLimitStart(null);
	$aItensRelacionados = $obj->getItensRelacionadas($aNoticia['post_palavra_chave']);

	$totalComentario = $obj->getTotal();
	
	$postTitulo = str_replace(' ', '+',$obj->retiraAcentos($_GET['post_titulo']));
?>
			<input type="hidden" name="post_id" id="post_id" value="<?php echo $_GET['post_id'] ?>"/>
			<script type="text/javascript" src="<?php echo "{$linkAbsolute}"?>js/noticias.js"></script>
        	<!-- Coluna Esquerda -->
            <div id="leftCol">

                <!-- Conteúdo -->
                <img src="<?php echo "{$linkAbsolute}"?>imgs/content_top.png" align="absbottom" />
                <div id="conteudo">
					<!-- nome da seção -->
					<h2><b class="title"><?php echo $aNoticia['categoria_nome']; ?></b></h2>

                    <!-- Conteúdo do Artigo -->
                    <div id="newsContent">
                    	<div class="newsHeader">
	                    	<h1><?php echo $aNoticia['post_titulo'] ?></h1>
                            <p class="autor"><?php echo $aNoticia['usuario_nome'] ?></p>
                            <p class="data"><?php echo $obj->dtExtensoNoticia($aNoticia['post_dtcomp_criacao']); ?></p>
                        </div>

                        <!-- Texto -->
                        <?php echo $aNoticia['post_conteudo']; ?>

                    </div>
					<?php if(count($aGaleria)>0){ ?>
                    <!-- Galeria vinculada à notícia (habilitar no admin) -->
                    <div id="newsGallery">
                    	<h2><b class="title">Galeria</b></h2>
						<?php foreach($aGaleria as $k => $v){ ?>
							<a href="<?php echo "{$linkAbsolute}galeria/{$v['imagem_galeria_id']}/{$v['galeria_id']}/{$postTitulo}/{$_GET['post_id']}"; ?>" class="img">
								<img src="<?php echo "{$linkAbsolute}galerias/galeria_{$v['galeria_id']}/{$v['imagem_galeria_imagem']}"; ?>" />
							</a>
						<?php } ?>
                        <p style="clear:both" align="right" class="comments"><a href="<?php echo "{$linkAbsolute}galeria/{$v['imagem_galeria_id']}/{$v['galeria_id']}/{$postTitulo}/{$_GET['post_id']}"; ?>">Veja todas as imagens</a>»</p>
                    </div>
					<?php } ?>

                	<!-- Comentários -->
                	<div id="comentarios">
                    	<h2><b class="title">Comentários (<?php echo count($aComentario); ?>)</b></h2>
                        <table width="100%">
                        	<tr>
                            	<td colspan="2">
									<?php if(!isset($_SESSION['GET_READY_GO_2011_SITE']['usuario_id']) && empty($_SESSION['GET_READY_GO_2011_SITE']['usuario_id'])){ ?>
										Nome: (Obrigatório)<br />
										<input type="text" class="text" id="nome" />
										<input type="hidden" id="usuario_id" value="0" />
									<?php }else{ ?>
										Nome: <strong style="font-style: italic"><?php echo $_SESSION['GET_READY_GO_2011_SITE']['usuario_nome'] ?></strong>
										<input type="hidden" id="nome" value="<?php echo $_SESSION['GET_READY_GO_2011_SITE']['usuario_nome'] ?>" />
										<input type="hidden" id="usuario_id" value="<?php echo $_SESSION['GET_READY_GO_2011_SITE']['usuario_id'] ?>" />
									<?php } ?>
								</td><!-- Só para quem não está logado -->
                            </tr>
                        	<tr>
								<td><textarea style="width:405px" rows="6" id="comentario"></textarea><br />Você ainda pode digitar <span class="qtdCaracteres">1000</span> caracteres</td>
                                <td valign="top">
                                   	<table class="smiles">
				                       	<tr>
                                        	<td valign="bottom"><a href="javascript:emoticon(':)')"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/smiley.gif" /></a></td>
                                        	<td valign="bottom"><a href="javascript:emoticon(':D')"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/cheesy.gif" /></a></td>
                                        	<td valign="bottom"><a href="javascript:emoticon(';)')"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/wink.gif" /></a></td>
                                        	<td valign="bottom"><a href="javascript:emoticon(':o')"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/(eek).gif" /></a></td>
                                        	<td valign="bottom"><a href="javascript:emoticon(':p')"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/tongue.gif" /></a></td>
                                        	<td valign="bottom"><a href="javascript:emoticon('B)')"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/cool.gif" /></a></td>
                                        </tr>
                                        <tr>
                                        	<td valign="bottom"><a href="javascript:emoticon(':@')"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/mad.gif" /></a></td>
                                        	<td valign="bottom"><a href="javascript:emoticon(':/')"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/undecided.gif" /></a></td>
                                        	<td valign="bottom"><a href="javascript:emoticon(':blush:')"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/iredface.gif" /></a></td>
                                        	<td valign="bottom"><a href="javascript:emoticon(':(')"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/triste.gif" /></a></td>
                                        	<td valign="bottom"><a href="javascript:emoticon(':ugh:')"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/ugh.gif" /></a></td>
                                        	<td valign="bottom"><a href="javascript:emoticon(':kiss:')"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/kiss.gif" /></a></td>
                                        </tr>
                                        <tr>
                                        	<td valign="bottom"><a href="javascript:emoticon(':roll:')"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/roll.gif" /></a></td>
                                        	<td valign="bottom"><a href="javascript:emoticon(':arrow:')"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/arrowan0.gif" /></a></td>
                                        	<td valign="bottom"><a href="javascript:emoticon(':bow:')"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/bowdown.gif" /></a></td>
                                        	<td valign="bottom"><a href="javascript:emoticon(':hate:')"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/fdp.gif" /></a></td>
                                        	<td valign="bottom"><a href="javascript:emoticon(':wtf:')"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/hum.gif" /></a></td>
                                        	<td valign="bottom"><a href="javascript:emoticon(':cool:')"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/joia.gif" /></a></td>
                                        </tr>
                                        <tr>
                                            <td valign="bottom"><a href="javascript:emoticon(':not:')"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/nao.gif" /></a></td>
                                        	<td valign="bottom"><a href="javascript:emoticon(':run:')"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/runaway.gif" /></a></td>
                                        	<td valign="bottom"><a href="javascript:emoticon(':z:')"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/zzz.gif" /></a></td>
                                            <td colspan="3"></td>
                                    	</tr>
                                    </table>
                                </td>

                            </tr>
							<?php if(!isset($_SESSION['GET_READY_GO_2011_SITE']['usuario_id']) && empty($_SESSION['GET_READY_GO_2011_SITE']['usuario_id'])){ ?>
                            <tr>
                            	<td colspan="2">
									<img src="<?php echo "{$linkAbsolute}"?>captcha.php?sid=<?php echo md5(time()) ?>" id="imageCaptcha" />
									<br /><input type="text" class="text" id="captcha" />
								</td><!-- Só para quem não está logado -->
							</tr>
							<?php }else{ ?>
							
							<?php } ?>
                            <tr>
                            	<td align="right" colspan="2"><input type="image" src="<?php echo "{$linkAbsolute}"?>imgs/bt_enviar.gif" id="enviarComentario" /></td>
                            </tr>
                        </table>
						<?php
							if(is_array($aComentario) && count($aComentario)>0){
						?>
							<div id="listagem">
								<div id="listagem_0">
								<?php foreach($aComentario as $k => $v){ ?>
								<table class="comentario" cellspacing="0" cellpadding="5">
									<tr>
										<td align="center" valign="top" width="135px">
											<?php if($v['usuario_avatar']==''){ ?>
											<img src="<?php echo $linkAbsolute ?>imgs/avatares/1.jpg" class="avatar" />
											<?php }else{ 
													if(@file_get_contents("{$linkAbsolute}avatars/{$v['usuario_avatar']}")==true){
														$file = "{$linkAbsolute}avatars/{$v['usuario_avatar']}";
													}else{
														$file = "{$linkAbsolute}avatar_user/{$v['usuario_avatar']}";
													}
											?>
											
											<img src="<?php echo "{$file}" ?>" class="avatar" />
											<?php } ?>
											<!--p style="font-size:14px; font-weight: bold">15<p>
											<a href="#"><img src="<?php echo "{$linkAbsolute}"?>imgs/pos.gif" /></a>
											<a href="#"><img src="<?php echo "{$linkAbsolute}"?>imgs/neg.gif" /></a-->
											<!-- Avaliação de comentário só para usuários cadastrados -->
										</td>
										<td valign="top">
											<p><a href="#"><strong><?php echo $v['comentario_autor']; ?></strong></a></p>
											<p class="data"><?php echo $obj->dtExtensoComentario($v['comentario_dtcomp_criacao']) ?></p>
											<p>
												<?php echo str_replace("@LINKABSOLUTO@",$linkAbsolute,$obj->tagToEmoticon($v['comentario_conteudo'])); ?>
											</p>
										</td>
									</tr>
								</table>
								<?php } ?>
								</div>
							</div>
							<?php if($totalComentario>=12){ ?>
								<p class="paginacao">
									«<a href="javascript:void(0)" class="inicio">Início</a>
									<a href="javascript:void(0)" class="anterior">Anterior</a>
									<?php
										$porPage = 0;
										for($i=1;$i<=ceil($totalComentario/12);$i++):

										$displayNone = ($i<=5)?'':'displayNone';
										$actActive = ($i==1)?'ativoPaginacao':'';
									?>
										<a href="javascript:void(0)" id="limit_baixo_<?php echo $porPage ?>" class="paginacaoPage <?php echo "{$displayNone} {$actActive}"?>"><?php echo $i; ?></a>
									<?php
										$porPage += 12;
										endfor;
									?>

									<a href="javascript:void(0)" class="proximo">Próximo</a>
									<a href="javascript:void(0)" class="fim">Fim</a>
									»
								</p>
							<?php } ?>
						<?php } ?>
						</div>
					</div>
                <img src="<?php echo "{$linkAbsolute}"?>imgs/content_bot.png" align="top" />
			</div>
            <!-- Coluna Direita -->
<?php
	include_once 'includes/lateralDireita.php';
	include_once 'includes/footer.php';
?>