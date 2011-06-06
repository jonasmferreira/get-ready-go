<?php
	include_once 'includes/cabecalho.php';
	include_once 'includes/header.php';

	require_once "class/home.class.php";

	$obj = new home();
	$obj->setCategoria_id($_GET['categoria_id']);
	$obj->setLimitMax(3);
	$obj->setLimitStart(0);
	$aLista = $obj->getLastPost();

?>
			<script type="text/javascript">
				$(document).ready(function(){
					$('.anterior').click(function(){
						 $(".paginacao a.ativoPaginacao").prev().trigger("click");
					});
					$('.proximo').click(function(){
						$(".paginacao a.ativoPaginacao").next().trigger("click");
					});
					$('.inicio').click(function(){
						$(".paginacao a.paginacaoPage").fadeIn();
						$(".paginacao a.paginacaoPage").first().trigger("click");
					});
					$('.fim').click(function(){
						$(".paginacao a.paginacaoPage").fadeIn();
						$(".paginacao a.paginacaoPage").last().trigger("click");
					});
					$(".paginacaoPage:not(:.ativoPaginacao)").live('click',function(e){
						var obj = $(this);
						var idAtivo = $(".paginacao a.ativoPaginacao").attr('id').split("_").pop();
						obj.next().fadeIn();
						$(".paginacao a").removeClass("ativoPaginacao");
						obj.addClass("ativoPaginacao");
						var paginacao = obj.context.id.split("_").pop();
						var pagePaginacao = $("#listagem_"+""+paginacao);
						if(pagePaginacao.html()==null){
							$.ajax({
								'type':'POST',
								'async':false,
								'url':'<?php echo $linkAbsolute;?>ajax/ajaxPaginacao',
								'dataType':'html',
								'data':{
									'action':'listagem',
									'categoria_id':<?php echo $_GET['categoria_id']?>,
									'limit':paginacao
								},
								success:function(resp){
									resp = resp.replace(/@LINKABSOLUTO@/g, '<?php echo $linkAbsolute;?>');
									$("#listagem_"+idAtivo).fadeOut('fast',function(){
										pagePaginacao.fadeIn();
										$("#listagem").append(resp);
									});
								}
							});
						}else{
							$("#listagem_"+idAtivo).fadeOut('fast',function(){
								pagePaginacao.fadeIn('slow');
							});
						}
					})
				});
			</script>
        	<!-- Coluna Esquerda -->
            <div id="leftCol">
            
                <!-- Conteúdo -->
                <img src="<?php echo "{$linkAbsolute}"?>imgs/content_top.png" align="absbottom" />
                <div id="conteudo">
					<!-- Últimas Notícias -->
					<h2><b class="title"><?php echo $aLista[0]['categoria_nome']; ?></b></h2>

                	<!-- Notícia -->
					<div id="listagem">
						<div id="listagem_0">
					<?php foreach($aLista as $k => $v){ ?>
							<div id="newsItem">
								<div id="newsImg">
									<a href="<?php echo "{$linkAbsolute}{$v['linkDetalhe']}"; ?>">
										<img src="<?php echo "{$linkAbsolute}posts/{$v['post_thumb_home']}"; ?>" width="150px" height="80px" alt="<?php echo $v['post_titulo']; ?>" />
									</a>
								</div>
								<div id="newsInfo">
									<h3>
										<a href="<?php echo "{$linkAbsolute}{$v['linkDetalhe']}"; ?>">
											<?php echo $v['post_titulo']; ?>
										</a>
									</h3>
									<p class="data"><?php echo $v['post_dt_criacao']; ?></p>
									<p><?php echo $obj->cutHTML($v['post_conteudo'],120); ?></p>
									<p class="comments"><img src="imgs/icon_comentario.gif" align="absmiddle" /> <a href="#"><?php echo $v['qtdComentario']; ?> comentários</a></p>
								</div>
							</div>
					<?php } ?>
						</div>
					</div>
					
					<p class="paginacao">
						«<a href="javascript:void(0)" class="inicio">Início</a>
						<a href="javascript:void(0)" class="anterior">Anterior</a>
						<?php
							$porPage = 0;
							for($i=1;$i<=ceil($obj->getTotal()/3);$i++):
							
							$displayNone = ($i<=5)?'':'displayNone';
							$actActive = ($i==1)?'ativoPaginacao':'';
						?>
							<a href="javascript:void(0)" id="limit_<?php echo $porPage ?>" class="paginacaoPage <?php echo "{$displayNone} {$actActive}"?>"><?php echo $i; ?></a>
						<?php
							$porPage += 3;
							endfor;
						?>
						
						<a href="javascript:void(0)" class="proximo">Próximo</a>
						<a href="javascript:void(0)" class="fim">Fim</a>
						»</p>
                
                </div>
                <img src="<?php echo "{$linkAbsolute}"?>imgs/content_bot.png" align="top" />
                 
            </div>
            <!-- Coluna Direita -->
            <div id="rightCol">
            	                    
            	<!-- Banner 300x250 -->
            	<div id="sideBanner"><img src="<?php echo "{$linkAbsolute}"?>banners/banner_300x250.jpg" /></div>

				<!-- Top noticias -->
                <img src="imgs/box_top.png" align="absbottom" />
                <div id="rightBox" class="topNoticias">
                	<h2><b class="title">Top notícias</b></h2>
                    <div class="item">
                    	<div class="img"><a href="noticia.html"><img src="<?php echo "{$linkAbsolute}"?>imgs/news/15.jpg" /></a></div>
                        <div class="info"><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">10 comentários</span></div>
                    </div>

                    <div class="item">
                    	<div class="img"><a href="noticia.html"><img src="<?php echo "{$linkAbsolute}"?>imgs/news/02.jpg" /></a></div>
                        <div class="info"><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">10 comentários</span></div>
                    </div>

                    <div class="item">
                    	<div class="img"><a href="noticia.html"><img src="<?php echo "{$linkAbsolute}"?>imgs/news/07.jpg" /></a></div>
                        <div class="info"><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">10 comentários</span></div>
                    </div>

                    <div class="item">
                    	<div class="img"><a href="noticia.html"><img src="<?php echo "{$linkAbsolute}"?>imgs/news/09.jpg" /></a></div>
                        <div class="info"><a href="noticia.html">Lorem ipsum dolor sit amet</a><br /><span class="data">10 comentários</span></div>
                    </div>

                    <div class="item">
                    	<div class="img"><a href="noticia.html"><img src="<?php echo "{$linkAbsolute}"?>imgs/news/03.jpg" /></a></div>
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
                <img src="<?php echo "{$linkAbsolute}"?>imgs/box_bot.png" align="top" style="clear:both" />

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