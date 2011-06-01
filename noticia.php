<?php
	include_once 'includes/cabecalho.php';
	include_once 'includes/header.php';
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
	                    	<h1>Batman: Arkham City já tem data de lançamento!</h1>
                            <p class="autor">Escrito por Fulano de Tal</p>
                            <p class="data">Sex, 11 de Março de 2011 17:35</p>
                        </div>

                        <!-- Texto -->
                        <p>A Warner Bros. Interactive Entertainment e a DC Entertainment anunciaram hoje que Batman: Arkham City sairá das sombras para as prateleiras dia 18 de outubro na América do Norte, dia 19 na Austrália e dia 21 no Reino Unido.</p>
                        <p>Junto com a data de laçamento, foram liberadas mais imagens do jogo (<a href="galeria.html">veja a galeria</a>) e a descrição oficial.</p>
                        <p><em><strong>Batman: Arkham City</strong> se utiliza da atmosfera intensa de Batman: Arkham Asylum, levando os jogadores à Arkham City – cinco vezes maior que o cenário de Batman: Arkham Asylum – o novo "lar" de segurança máxima para todos os bandidos, gangsters e mentes criminosas de Gotham City. Localizada dentro dos muros fortificados de um distrito no coração de Gotham City, essa tão esperada sequencia introduz uma nova história, um elenco com personagens clássicos e vilões assassinos do universo de Batman, e uma vasta variedade de novos aspectos de jogabilidade para criar a experiência máxima como o Cavaleiro das Trevas.</em></p>
                        <p>Ao que parece, o Halloween promete esse ano! E quais os seus pensamentos sobre o jogo?</p>

                    </div>

                    <!-- Galeria vinculada à notícia (habilitar no admin) -->
                    <div id="newsGallery">
                    	<h2><b class="title">Galeria</b></h2>
                        <a href="galeria.html" class="img"><img src="imgs/galerias/jogo1_01.jpg" /></a>
                        <a href="galeria.html" class="img"><img src="imgs/galerias/jogo1_02.jpg" /></a>
                        <a href="galeria.html" class="img"><img src="imgs/galerias/jogo1_03.jpg" /></a>
                        <a href="galeria.html" class="img"><img src="imgs/galerias/jogo1_04.jpg" /></a>
                        <p style="clear:both" align="right" class="comments"><a href="#">Veja todas as imagens</a>»</p>
                    </div>

                	<!-- Comentários -->
                	<div id="comentarios">
                    	<h2><b class="title">Comentários (10)</b></h2>
                        <table width="100%">
                        	<tr>
                            	<td colspan="2">Nome: (Obrigatório)<br /><input type="text" class="text" /></td><!-- Só para quem não está logado -->
                            </tr>
                        	<tr>
                            	<td><textarea style="width:405px" rows="6"></textarea><br />Você ainda pode digitar 1000 caracteres</td>
                                <td valign="top">
                                   	<table class="smiles">
				                       	<tr>
                                        	<td valign="bottom"><a href="#"><img src="imgs/smiles/smiley.gif" /></a></td>
                                        	<td valign="bottom"><a href="#"><img src="imgs/smiles/cheesy.gif" /></a></td>
                                        	<td valign="bottom"><a href="#"><img src="imgs/smiles/wink.gif" /></a></td>
                                        	<td valign="bottom"><a href="#"><img src="imgs/smiles/(eek).gif" /></a></td>
                                        	<td valign="bottom"><a href="#"><img src="imgs/smiles/tongue.gif" /></a></td>
                                        	<td valign="bottom"><a href="#"><img src="imgs/smiles/cool.gif" /></a></td>
                                        </tr>
                                        <tr>
                                        	<td valign="bottom"><a href="#"><img src="imgs/smiles/mad.gif" /></a></td>
                                        	<td valign="bottom"><a href="#"><img src="imgs/smiles/undecided.gif" /></a></td>
                                        	<td valign="bottom"><a href="#"><img src="imgs/smiles/iredface.gif" /></a></td>
                                        	<td valign="bottom"><a href="#"><img src="imgs/smiles/triste.gif" /></a></td>
                                        	<td valign="bottom"><a href="#"><img src="imgs/smiles/ugh.gif" /></a></td>
                                        	<td valign="bottom"><a href="#"><img src="imgs/smiles/kiss.gif" /></a></td>
                                        </tr>
                                        <tr>
                                        	<td valign="bottom"><a href="#"><img src="imgs/smiles/roll.gif" /></a></td>
                                        	<td valign="bottom"><a href="#"><img src="imgs/smiles/arrowan0.gif" /></a></td>
                                        	<td valign="bottom"><a href="#"><img src="imgs/smiles/bowdown.gif" /></a></td>
                                        	<td valign="bottom"><a href="#"><img src="imgs/smiles/fdp.gif" /></a></td>
                                        	<td valign="bottom"><a href="#"><img src="imgs/smiles/hum.gif" /></a></td>
                                        	<td valign="bottom"><a href="#"><img src="imgs/smiles/joia.gif" /></a></td>
                                        </tr>
                                        <tr>
                                            <td valign="bottom"><a href="#"><img src="imgs/smiles/nao.gif" /></a></td>
                                        	<td valign="bottom"><a href="#"><img src="imgs/smiles/runaway.gif" /></a></td>
                                        	<td valign="bottom"><a href="#"><img src="imgs/smiles/zzz.gif" /></a></td>
                                            <td colspan="3"></td>
                                    	</tr>
                                    </table>
                                </td>

                            </tr>
                            <tr>
                            	<td colspan="2"><img src="imgs/captcha.jpg" /><br /><input type="text" class="text" /></td><!-- Só para quem não está logado -->
                            <tr>
                            	<td align="right" colspan="2"><input type="image" src="imgs/bt_enviar.gif" /></td>
                            </tr>
                        </table>
						<p class="paginacao">«<a href="#">Início</a> <a href="#">Anterior</a> <a href="#">1</a> <strong>2</strong> <a href="#">3</a> <a href="#">4</a> <a href="#">5</a> <a href="#">Próximo</a> <a href="#">Fim</a>»</p>

                        <!-- Comentário -->
                        <table class="comentario" cellspacing="0" cellpadding="5">
                        	<tr>
                            	<td align="center" valign="top">
                                	<img src="imgs/avatares/1.jpg" class="avatar" /><!-- Avatar Pafrão para não usuários e usuários que ainda não escolheram avatar -->
                                    <p style="font-size:14px; font-weight: bold">15<p>
                                    <a href="#"><img src="imgs/pos.gif" /></a>
                                    <a href="#"><img src="imgs/neg.gif" /></a>
                                    <!-- Avaliação de comentário só para usuários cadastrados -->
                                </td>
                                <td valign="top">
                                	<p><a href="#"><strong>Nome do usuário</strong></a></p>
                                    <p class="data">Em 11 de Março de 2011, às 17:35</p>
                                    <p>Mensagem aqui. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                                </td>
                            </tr>
                        </table>

                        <!-- Comentário -->
                        <table class="comentario" cellspacing="0" cellpadding="5">
                        	<tr>
                            	<td align="center" valign="top">
                                	<img src="imgs/avatares/1.jpg" class="avatar" />
                                    <p style="font-size:14px; font-weight: bold">15<p>
                                    <a href="#"><img src="imgs/pos.gif" /></a>
                                    <a href="#"><img src="imgs/neg.gif" /></a>
                                </td>
                                <td valign="top">
                                	<p><a href="#"><strong>Nome do usuário</strong></a></p>
                                    <p class="data">Em 11 de Março de 2011, às 17:35</p>
                                    <p>Mensagem aqui. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                                </td>
                            </tr>
                        </table>

                        <!-- Comentário -->
                        <table class="comentario" cellspacing="0" cellpadding="5">
                        	<tr>
                            	<td align="center" valign="top">
                                	<img src="imgs/avatares/1.jpg" class="avatar" />
                                    <p style="font-size:14px; font-weight: bold">15<p>
                                    <a href="#"><img src="imgs/pos.gif" /></a>
                                    <a href="#"><img src="imgs/neg.gif" /></a>
                                </td>
                                <td valign="top">
                                	<p><a href="#"><strong>Nome do usuário</strong></a></p>
                                    <p class="data">Em 11 de Março de 2011, às 17:35</p>
                                    <p>Mensagem aqui. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                                </td>
                            </tr>
                        </table>

                        <!-- Comentário -->
                        <table class="comentario" cellspacing="0" cellpadding="5">
                        	<tr>
                            	<td align="center" valign="top">
                                	<img src="imgs/avatares/1.jpg" class="avatar" />
                                    <p style="font-size:14px; font-weight: bold">15<p>
                                    <a href="#"><img src="imgs/pos.gif" /></a>
                                    <a href="#"><img src="imgs/neg.gif" /></a>
                                </td>
                                <td valign="top">
                                	<p><a href="#"><strong>Nome do usuário</strong></a></p>
                                    <p class="data">Em 11 de Março de 2011, às 17:35</p>
                                    <p>Mensagem aqui. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                                </td>
                            </tr>
                        </table>

                        <!-- Comentário -->
                        <table class="comentario" cellspacing="0" cellpadding="5">
                        	<tr>
                            	<td align="center" valign="top">
                                	<img src="imgs/avatares/1.jpg" class="avatar" />
                                    <p style="font-size:14px; font-weight: bold">15<p>
                                    <a href="#"><img src="imgs/pos.gif" /></a>
                                    <a href="#"><img src="imgs/neg.gif" /></a>
                                </td>
                                <td valign="top">
                                	<p><a href="#"><strong>Nome do usuário</strong></a></p>
                                    <p class="data">Em 11 de Março de 2011, às 17:35</p>
                                    <p>Mensagem aqui. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                                </td>
                            </tr>
                        </table>

                        <!-- Comentário -->
                        <table class="comentario" cellspacing="0" cellpadding="5">
                        	<tr>
                            	<td align="center" valign="top">
                                	<img src="imgs/avatares/1.jpg" class="avatar" />
                                    <p style="font-size:14px; font-weight: bold">15<p>
                                    <a href="#"><img src="imgs/pos.gif" /></a>
                                    <a href="#"><img src="imgs/neg.gif" /></a>
                                </td>
                                <td valign="top">
                                	<p><a href="#"><strong>Nome do usuário</strong></a></p>
                                    <p class="data">Em 11 de Março de 2011, às 17:35</p>
                                    <p>Mensagem aqui. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                                </td>
                            </tr>
                        </table>

                        <!-- Comentário -->
                        <table class="comentario" cellspacing="0" cellpadding="5">
                        	<tr>
                            	<td align="center" valign="top">
                                	<img src="imgs/avatares/1.jpg" class="avatar" />
                                    <p style="font-size:14px; font-weight: bold">15<p>
                                    <a href="#"><img src="imgs/pos.gif" /></a>
                                    <a href="#"><img src="imgs/neg.gif" /></a>
                                </td>
                                <td valign="top">
                                	<p><a href="#"><strong>Nome do usuário</strong></a></p>
                                    <p class="data">Em 11 de Março de 2011, às 17:35</p>
                                    <p>Mensagem aqui. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                                </td>
                            </tr>
                        </table>

                        <!-- Comentário -->
                        <table class="comentario" cellspacing="0" cellpadding="5">
                        	<tr>
                            	<td align="center" valign="top">
                                	<img src="imgs/avatares/1.jpg" class="avatar" />
                                    <p style="font-size:14px; font-weight: bold">15<p>
                                    <a href="#"><img src="imgs/pos.gif" /></a>
                                    <a href="#"><img src="imgs/neg.gif" /></a>
                                </td>
                                <td valign="top">
                                	<p><a href="#"><strong>Nome do usuário</strong></a></p>
                                    <p class="data">Em 11 de Março de 2011, às 17:35</p>
                                    <p>Mensagem aqui. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                                </td>
                            </tr>
                        </table>

                        <!-- Comentário -->
                        <table class="comentario" cellspacing="0" cellpadding="5">
                        	<tr>
                            	<td align="center" valign="top">
                                	<img src="imgs/avatares/1.jpg" class="avatar" />
                                    <p style="font-size:14px; font-weight: bold">15<p>
                                    <a href="#"><img src="imgs/pos.gif" /></a>
                                    <a href="#"><img src="imgs/neg.gif" /></a>
                                </td>
                                <td valign="top">
                                	<p><a href="#"><strong>Nome do usuário</strong></a></p>
                                    <p class="data">Em 11 de Março de 2011, às 17:35</p>
                                    <p>Mensagem aqui. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                                </td>
                            </tr>
                        </table>

                        <!-- Comentário -->
                        <table class="comentario" cellspacing="0" cellpadding="5">
                        	<tr>
                            	<td align="center" valign="top">
                                	<img src="imgs/avatares/1.jpg" class="avatar" />
                                    <p style="font-size:14px; font-weight: bold">15<p>
                                    <a href="#"><img src="imgs/pos.gif" /></a>
                                    <a href="#"><img src="imgs/neg.gif" /></a>
                                </td>
                                <td valign="top">
                                	<p><a href="#"><strong>Nome do usuário</strong></a></p>
                                    <p class="data">Em 11 de Março de 2011, às 17:35</p>
                                    <p>Mensagem aqui. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                                </td>
                            </tr>
                        </table>

                        <!-- Comentário -->
                        <table class="comentario" cellspacing="0" cellpadding="5">
                        	<tr>
                            	<td align="center" valign="top">
                                	<img src="imgs/avatares/1.jpg" class="avatar" />
                                    <p style="font-size:14px; font-weight: bold">15<p>
                                    <a href="#"><img src="imgs/pos.gif" /></a>
                                    <a href="#"><img src="imgs/neg.gif" /></a>
                                </td>
                                <td valign="top">
                                	<p><a href="#"><strong>Nome do usuário</strong></a></p>
                                    <p class="data">Em 11 de Março de 2011, às 17:35</p>
                                    <p>Mensagem aqui. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                                </td>
                            </tr>
                        </table>

						<p class="paginacao">«<a href="#">Início</a> <a href="#">Anterior</a> <a href="#">1</a> <strong>2</strong> <a href="#">3</a> <a href="#">4</a> <a href="#">5</a> <a href="#">Próximo</a> <a href="#">Fim</a>»</p>

                    </div>

                </div>
                <img src="imgs/content_bot.png" align="top" />

            </div>
            <!-- Coluna Direita -->
            <div id="rightCol">

				<!-- Itens relacionados -->
                <img src="imgs/box_top.png" align="absbottom" />
                <div id="rightBox" class="topArtigos">
                	<h2><b class="title">itens relacionados</b></h2>
                    <ul>
                    	<li><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">Notícia</span></li>
                    	<li><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">Artigo</span></li>
                    	<li><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">Análise</span></li>
                    	<li><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">Notícia</span></li>
                    	<li><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">Artigo</span></li>
                    	<li><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">Análise</span></li>
                    	<li><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">Notícia</span></li>
                    	<li><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">Artigo</span></li>
                    	<li><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">Análise</span></li>
                    	<li><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">Notícia</span></li>
                    </ul>
                </div>
                <img src="imgs/box_bot.png" align="top" style="clear:both" />

            	<!-- Banner 300x250 -->
            	<div id="sideBanner"><img src="banners/banner_300x250.jpg" /></div>

				<!-- Top noticias -->
                <img src="imgs/box_top.png" align="absbottom" />
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
                <img src="imgs/box_bot.png" align="top" style="clear:both" />

				<!-- Top artigos -->
                <img src="imgs/box_top.png" align="absbottom" />
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
                <img src="imgs/box_bot.png" align="top" style="clear:both" />

				<!-- Top noticias -->
                <img src="imgs/box_top.png" align="absbottom" />
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
                <img src="imgs/box_bot.png" align="top" style="clear:both" />

            </div>
<?php
	include_once 'includes/footer.php';
?>