<?php
	include_once 'includes/cabecalho.php';
	include_once 'includes/header.php';
	require_once 'class/noticia.class.php';
	require_once 'class/home.class.php';


	$obj = new noticia();
	$obj->setPost_id($_GET['post_id']);
	$aNoticia = $obj->getOne();
	$aGaleria = $obj->galeriaPost();
	$aComentario = $obj->comentarioPost();
	$aItensRelacionados = $obj->getItensRelacionadas($aNoticia['post_palavra_chave']);

	$objHome = new home();
	$objHome->setCategoria_id(1);
	$aNoticias = $objHome->getLastPost();

	$objHome->setCategoria_id(2);
	$aArtigo = $objHome->getLastPost();

	$objHome->setCategoria_id(3);
	$aAnalises = $objHome->getLastPost();

	$postTitulo = str_replace(' ', '+',$_GET['post_titulo']);

?>
        	<!-- Coluna Esquerda -->
            <div id="leftCol">

                <!-- Conteúdo -->
                <img src="imgs/content_top.png" align="absbottom" />
                <div id="conteudo">
					<!-- nome da seção -->
					<h2><b class="title">notícia</b></h2>

                    <!-- Conteúdo do Artigo -->
                    <div id="newsContent">
                    	<div class="newsHeader">
	                    	<h1><?php echo $aNoticia['post_titulo'] ?></h1>
                            <p class="autor"><?php echo $aNoticia['usuario_nome'] ?></p>
                            <p class="data">Sex, 11 de Março de 2011 17:35</p>
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
                        <p style="clear:both" align="right" class="comments"><a href="#">Veja todas as imagens</a>»</p>
                    </div>
					<?php } ?>

                	<!-- Comentários -->
                	<div id="comentarios">
                    	<h2><b class="title">Comentários (<?php echo $aNoticia['qtdComentario']; ?>)</b></h2>
                        <table width="100%">
                        	<tr>
                            	<td colspan="2">
									<?php if(!isset($_SESSION['GET_READY_GO_2011_SITE']['usuario_id']) && empty($_SESSION['GET_READY_GO_2011_SITE']['usuario_id'])){ ?>
										Nome: (Obrigatório)<br /><input type="text" class="text" />
									<?php }else{ ?>
										Nome: <strong style="font-style: italic"><?php echo $_SESSION['GET_READY_GO_2011_SITE']['usuario_nome'] ?></strong>
									<?php } ?>
								</td><!-- Só para quem não está logado -->
                            </tr>
                        	<tr>
                            	<td><textarea style="width:405px" rows="6"></textarea><br />Você ainda pode digitar 1000 caracteres</td>
                                <td valign="top">
                                   	<table class="smiles">
				                       	<tr>
                                        	<td valign="bottom"><a href="#"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/smiley.gif" /></a></td>
                                        	<td valign="bottom"><a href="#"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/cheesy.gif" /></a></td>
                                        	<td valign="bottom"><a href="#"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/wink.gif" /></a></td>
                                        	<td valign="bottom"><a href="#"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/(eek).gif" /></a></td>
                                        	<td valign="bottom"><a href="#"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/tongue.gif" /></a></td>
                                        	<td valign="bottom"><a href="#"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/cool.gif" /></a></td>
                                        </tr>
                                        <tr>
                                        	<td valign="bottom"><a href="#"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/mad.gif" /></a></td>
                                        	<td valign="bottom"><a href="#"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/undecided.gif" /></a></td>
                                        	<td valign="bottom"><a href="#"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/iredface.gif" /></a></td>
                                        	<td valign="bottom"><a href="#"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/triste.gif" /></a></td>
                                        	<td valign="bottom"><a href="#"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/ugh.gif" /></a></td>
                                        	<td valign="bottom"><a href="#"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/kiss.gif" /></a></td>
                                        </tr>
                                        <tr>
                                        	<td valign="bottom"><a href="#"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/roll.gif" /></a></td>
                                        	<td valign="bottom"><a href="#"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/arrowan0.gif" /></a></td>
                                        	<td valign="bottom"><a href="#"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/bowdown.gif" /></a></td>
                                        	<td valign="bottom"><a href="#"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/fdp.gif" /></a></td>
                                        	<td valign="bottom"><a href="#"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/hum.gif" /></a></td>
                                        	<td valign="bottom"><a href="#"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/joia.gif" /></a></td>
                                        </tr>
                                        <tr>
                                            <td valign="bottom"><a href="#"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/nao.gif" /></a></td>
                                        	<td valign="bottom"><a href="#"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/runaway.gif" /></a></td>
                                        	<td valign="bottom"><a href="#"><img src="<?php echo "{$linkAbsolute}"?>imgs/smiles/zzz.gif" /></a></td>
                                            <td colspan="3"></td>
                                    	</tr>
                                    </table>
                                </td>

                            </tr>
                            <tr>
                            	<td colspan="2"><img src="<?php echo "{$linkAbsolute}"?>imgs/captcha.jpg" /><br /><input type="text" class="text" /></td><!-- Só para quem não está logado -->
                            <tr>
                            	<td align="right" colspan="2"><input type="image" src="<?php echo "{$linkAbsolute}"?>imgs/bt_enviar.gif" /></td>
                            </tr>
                        </table>
						<?php if(count($aComentario)){ ?>
							<p class="paginacao">«<a href="#">Início</a> <a href="#">Anterior</a> <a href="#">1</a> <strong>2</strong> <a href="#">3</a> <a href="#">4</a> <a href="#">5</a> <a href="#">Próximo</a> <a href="#">Fim</a>»</p>
							<!-- Comentário -->
							<?php foreach($aComentario as $k => $v){ ?>
							<table class="comentario" cellspacing="0" cellpadding="5">
								<tr>
									<td align="center" valign="top">
										<img src="imgs/avatares/1.jpg" class="avatar" /><!-- Avatar Pafrão para não usuários e usuários que ainda não escolheram avatar -->
										<!--p style="font-size:14px; font-weight: bold">15<p>
										<a href="#"><img src="imgs/pos.gif" /></a>
										<a href="#"><img src="imgs/neg.gif" /></a-->
										<!-- Avaliação de comentário só para usuários cadastrados -->
									</td>
									<td valign="top">
										<p><a href="#"><strong><?php echo $v['comentario_autor']; ?></strong></a></p>
										<p class="data">Em 11 de Março de 2011, às 17:35</p>
										<p>
											<?php echo $v['comentario_conteudo']; ?>
										</p>
									</td>
								</tr>
							</table>
							<?php } ?>
							<p class="paginacao">«<a href="#">Início</a> <a href="#">Anterior</a> <a href="#">1</a> <strong>2</strong> <a href="#">3</a> <a href="#">4</a> <a href="#">5</a> <a href="#">Próximo</a> <a href="#">Fim</a>»</p>
						<?php } ?>
                    </div>

                </div>
                <img src="<?php echo "{$linkAbsolute}"?>imgs/content_bot.png" align="top" />

            </div>
            <!-- Coluna Direita -->
            <div id="rightCol">

				<!-- Itens relacionados -->
                <img src="imgs/box_top.png" align="absbottom" />
                <div id="rightBox" class="topArtigos">
                	<h2><b class="title">itens relacionados</b></h2>
                    <ul>
						<?php foreach($aItensRelacionados as $k => $v){ ?>
							<li>
								<a href="<?php echo "{$linkAbsolute}{$v['linkDetalhe']}"; ?>">
									<?php echo $v['post_titulo']; ?>
								</a>
								<br />
								<span class="data"><?php echo $v['categoria_nome']; ?></span>
							</li>
						<?php } ?>
                    </ul>
                </div>
                <img src="imgs/box_bot.png" align="top" style="clear:both" />

            	<!-- Banner 300x250 -->
            	<div id="sideBanner"><img src="banners/banner_300x250.jpg" /></div>

				<!-- Top noticias -->
                <img src="<?php echo "{$linkAbsolute}"?>imgs/box_top.png" align="absbottom" />
                <div id="rightBox" class="topNoticias">
                	<h2><b class="title">Top notícias</b></h2>
                    <div class="item">
                    	<div class="img"><a href="noticia.html"><img src="imgs/news/15.jpg" /></a></div>
                        <div class="info"><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">10 comentários</span></div>
                    </div>

                    <div class="item">
                    	<div class="img"><a href="noticia.html"><img src="imgs/news/02.jpg" /></a></div>
                        <div class="info"><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">10 comentários</span></div>
                    </div>

                    <div class="item">
                    	<div class="img"><a href="noticia.html"><img src="imgs/news/07.jpg" /></a></div>
                        <div class="info"><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">10 comentários</span></div>
                    </div>

                    <div class="item">
                    	<div class="img"><a href="noticia.html"><img src="imgs/news/09.jpg" /></a></div>
                        <div class="info"><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">10 comentários</span></div>
                    </div>

                    <div class="item">
                    	<div class="img"><a href="noticia.html"><img src="imgs/news/03.jpg" /></a></div>
                        <div class="info"><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">10 comentários</span></div>
                    </div>

                    <div style="clear:both"></div>
                </div>
                <img src="<?php echo "{$linkAbsolute}"?>imgs/box_bot.png" align="top" style="clear:both" />

				<!-- Top artigos -->
                <img src="<?php echo "{$linkAbsolute}"?>imgs/box_top.png" align="absbottom" />
                <div id="rightBox" class="topArtigos">
                	<h2><b class="title">Top artigos</b></h2>
                    <ul>
                    	<li><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">10 comentários</span></li>
                    	<li><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">10 comentários</span></li>
                    	<li><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">10 comentários</span></li>
                    	<li><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">10 comentários</span></li>
                    	<li><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">10 comentários</span></li>
                    	<li><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">10 comentários</span></li>
                    	<li><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">10 comentários</span></li>
                    	<li><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">10 comentários</span></li>
                    </ul>
                </div>
                <img src=<?php echo "{$linkAbsolute}"?>"imgs/box_bot.png" align="top" style="clear:both" />

				<!-- Top noticias -->
                <img src="<?php echo "{$linkAbsolute}"?>imgs/box_top.png" align="absbottom" />
                <div id="rightBox" class="topNoticias">
                	<h2><b class="title">Top análises</b></h2>
                    <div class="item">
                    	<div class="img"><a href="noticia.html"><img src="imgs/news/12.jpg" /></a></div>
                        <div class="info"><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">10 comentários</span></div>
                    </div>

                    <div class="item">
                    	<div class="img"><a href="noticia.html"><img src="imgs/news/10.jpg" /></a></div>
                        <div class="info"><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">10 comentários</span></div>
                    </div>

                    <div class="item">
                    	<div class="img"><a href="noticia.html"><img src="imgs/news/01.jpg" /></a></div>
                        <div class="info"><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">10 comentários</span></div>
                    </div>

                    <div class="item">
                    	<div class="img"><a href="noticia.html"><img src="imgs/news/08.jpg" /></a></div>
                        <div class="info"><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">10 comentários</span></div>
                    </div>

                    <div class="item">
                    	<div class="img"><a href="noticia.html"><img src="imgs/news/04.jpg" /></a></div>
                        <div class="info"><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">10 comentários</span></div>
                    </div>

                    <div style="clear:both"></div>
                </div>
                <img src="<?php echo "{$linkAbsolute}"?>imgs/box_bot.png" align="top" style="clear:both" />

            </div>
<?php
	include_once 'includes/footer.php';
?>