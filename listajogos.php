<?php
	include_once 'includes/cabecalho.php';
	include_once 'includes/header.php';

	require_once "class/home.class.php";

	$obj = new home();
	$obj->setCategoria_id($_GET['categoria_id']);
	$obj->setLimitMax(15);
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
                <img src="imgs/content_top.png" align="absbottom" />
                <div id="conteudo">
					<!-- Mais Jogado -->
					<h2><b class="title">Mais Jogado</b></h2>
                    
                    <!-- Jogo mais popular (maior número de visualizações no mês) -->
                    <div id="mostPlayed">
                    	<div id="gameImg"><a href="jogo_download.html"><img src="imgs/jogos/jogo1_big.jpg" /></a></div>
                        <div id="gameInfo">
							<p class="data">Para Download</p>
                        	<h3><a href="jogo_download.html">Lorem ipsum dolor sit amet</a></h3>
                            <p><img src="imgs/nota_09.jpg" /></p>
							<p class="data">Jogado 57 vezes</p>
                            <p class="autor">
                            	Criado por<br />
								<img src="imgs/avatares/1.jpg" align="absmiddle" /> <a href="#"><strong>Fulano de tal</strong></a>
                            </p>
                        </div>
                    </div>
					<div style="clear:both"></div>
					<!-- Últimos jogos -->
                    
                    <div id="twoCol">
                    	<h2><b class="title">mais votados</b></h2>

	                    <!-- item -->
    	                <div class="itemJogos">
        	            	<div class="imgItemJogos"><a href="jogo_browser.html"><img src="imgs/jogos/jogo1.jpg" /></a></div>
            	            <div><a href="jogo_browser.html">Nome do jogo</a><br />Aventura | Browser Game<br /><strong>Nome do criador do jogo</strong><br />Jogado 10 vezes</div>
                	    </div>

	                    <!-- item -->
    	                <div class="itemJogos">
        	            	<div class="imgItemJogos"><a href="jogo_download.html"><img src="imgs/jogos/jogo2.jpg" /></a></div>
            	            <div><a href="jogo_download.html">Nome do jogo</a><br />Aventura | Para Download<br /><strong>Nome do criador do jogo</strong><br />Jogado 10 vezes</div>
                	    </div>

	                    <!-- item -->
    	                <div class="itemJogos">
        	            	<div class="imgItemJogos"><a href="jogo_browser.html"><img src="imgs/jogos/jogo3.jpg" /></a></div>
            	            <div><a href="jogo_browser.html">Nome do jogo</a><br />Aventura | Browser Game<br /><strong>Nome do criador do jogo</strong><br />Jogado 10 vezes</div>
                	    </div>                        
                    </div>

                    <div id="twoCol">
                    	<h2><b class="title">Populares</b></h2>

	                    <!-- item -->
    	                <div class="itemJogos">
        	            	<div class="imgItemJogos"><a href="jogo_browser.html"><img src="imgs/jogos/jogo4.jpg" /></a></div>
            	            <div><a href="jogo_browser.html">Nome do jogo</a><br />Aventura | Browser Game<br /><strong>Nome do criador do jogo</strong><br />Jogado 10 vezes</div>
                	    </div>

	                    <!-- item -->
    	                <div class="itemJogos">
        	            	<div class="imgItemJogos"><a href="jogo_download.html"><img src="imgs/jogos/jogo5.jpg" /></a></div>
            	            <div><a href="jogo_download.html">Nome do jogo</a><br />Aventura | Para Download<br /><strong>Nome do criador do jogo</strong><br />Jogado 10 vezes</div>
                	    </div>

	                    <!-- item -->
    	                <div class="itemJogos">
        	            	<div class="imgItemJogos"><a href="jogo_browser.html"><img src="imgs/jogos/jogo6.jpg" /></a></div>
            	            <div><a href="jogo_browser.html">Nome do jogo</a><br />Aventura | Browser Game<br /><strong>Nome do criador do jogo</strong><br />Jogado 10 vezes</div>
                	    </div>
                        
                    </div>
                    <div style="clear:both"></div>
                
                </div>
                <img src="imgs/content_bot.png" align="top" />

                <!-- Conteúdo -->
                <img src="imgs/content_top.png" align="absbottom" />
                <div id="conteudo">
					<h2><b class="title">últimos</b></h2>

                    <div id="twoCol">

	                    <!-- item -->
    	                <div class="itemJogos">
        	            	<div class="imgItemJogos"><a href="jogo_download.html"><img src="imgs/jogos/jogo1.jpg" /></a></div>
            	            <div><a href="jogo_download.html">Nome do jogo</a><br />Aventura | Para Download<br /><strong>Nome do criador do jogo</strong><br />Jogado 10 vezes</div>
                	    </div>

	                    <!-- item -->
    	                <div class="itemJogos">
        	            	<div class="imgItemJogos"><a href="jogo_browser.html"><img src="imgs/jogos/jogo2.jpg" /></a></div>
            	            <div><a href="jogo_browser.html">Nome do jogo</a><br />Aventura | Browser Game<br /><strong>Nome do criador do jogo</strong><br />Jogado 10 vezes</div>
                	    </div>

	                    <!-- item -->
    	                <div class="itemJogos">
        	            	<div class="imgItemJogos"><a href="jogo_browser.html"><img src="imgs/jogos/jogo3.jpg" /></a></div>
            	            <div><a href="jogo_browser.html">Nome do jogo</a><br />Aventura | Para Download<br /><strong>Nome do criador do jogo</strong><br />Jogado 10 vezes</div>
                	    </div>                        

	                    <!-- item -->
    	                <div class="itemJogos">
        	            	<div class="imgItemJogos"><a href="jogo_browser.html"><img src="imgs/jogos/jogo4.jpg" /></a></div>
            	            <div><a href="jogo_browser.html">Nome do jogo</a><br />Aventura | Browser Game<br /><strong>Nome do criador do jogo</strong><br />Jogado 10 vezes</div>
                	    </div>

	                    <!-- item -->
    	                <div class="itemJogos">
        	            	<div class="imgItemJogos"><a href="jogo_browser.html"><img src="imgs/jogos/jogo5.jpg" /></a></div>
            	            <div><a href="jogo_browser.html">Nome do jogo</a><br />Aventura | Browser Game<br /><strong>Nome do criador do jogo</strong><br />Jogado 10 vezes</div>
                	    </div>

	                    <!-- item -->
    	                <div class="itemJogos">
        	            	<div class="imgItemJogos"><a href="jogo_download.html"><img src="imgs/jogos/jogo6.jpg" /></a></div>
            	            <div><a href="jogo_download.html">Nome do jogo</a><br />Aventura | Para Download<br /><strong>Nome do criador do jogo</strong><br />Jogado 10 vezes</div>
                	    </div>

	                    <!-- item -->
    	                <div class="itemJogos">
        	            	<div class="imgItemJogos"><a href="jogo_browser.html"><img src="imgs/jogos/jogo1.jpg" /></a></div>
            	            <div><a href="jogo_browser.html">Nome do jogo</a><br />Aventura | Browser Game<br /><strong>Nome do criador do jogo</strong><br />Jogado 10 vezes</div>
                	    </div>

	                    <!-- item -->
    	                <div class="itemJogos">
        	            	<div class="imgItemJogos"><a href="jogo_browser.html"><img src="imgs/jogos/jogo2.jpg" /></a></div>
            	            <div><a href="jogo_browser.html">Nome do jogo</a><br />Aventura | Browser Game<br /><strong>Nome do criador do jogo</strong><br />Jogado 10 vezes</div>
                	    </div>

	                    <!-- item -->
    	                <div class="itemJogos">
        	            	<div class="imgItemJogos"><a href="jogo_download.html"><img src="imgs/jogos/jogo3.jpg" /></a></div>
            	            <div><a href="jogo_download.html">Nome do jogo</a><br />Aventura | Para Download<br /><strong>Nome do criador do jogo</strong><br />Jogado 10 vezes</div>
                	    </div>                        

	                    <!-- item -->
    	                <div class="itemJogos">
        	            	<div class="imgItemJogos"><a href="jogo_browser.html"><img src="imgs/jogos/jogo4.jpg" /></a></div>
            	            <div><a href="jogo_browser.html">Nome do jogo</a><br />Aventura | Browser Game<br /><strong>Nome do criador do jogo</strong><br />Jogado 10 vezes</div>
                	    </div>

	                    <!-- item -->
    	                <div class="itemJogos">
        	            	<div class="imgItemJogos"><a href="jogo_browser.html"><img src="imgs/jogos/jogo5.jpg" /></a></div>
            	            <div><a href="jogo_browser.html">Nome do jogo</a><br />Aventura | Browser Game<br /><strong>Nome do criador do jogo</strong><br />Jogado 10 vezes</div>
                	    </div>

	                    <!-- item -->
    	                <div class="itemJogos">
        	            	<div class="imgItemJogos"><a href="jogo_browser.html"><img src="imgs/jogos/jogo6.jpg" /></a></div>
            	            <div><a href="jogo_browser.html">Nome do jogo</a><br />Aventura | Browser Game<br /><strong>Nome do criador do jogo</strong><br />Jogado 10 vezes</div>
                	    </div>
                        
                    </div>
                    <div id="twoCol">

	                    <!-- item -->
    	                <div class="itemJogos">
        	            	<div class="imgItemJogos"><a href="jogo_browser.html"><img src="imgs/jogos/jogo1.jpg" /></a></div>
            	            <div><a href="jogo_browser.html">Nome do jogo</a><br />Aventura | Browser Game<br /><strong>Nome do criador do jogo</strong><br />Jogado 10 vezes</div>
                	    </div>

	                    <!-- item -->
    	                <div class="itemJogos">
        	            	<div class="imgItemJogos"><a href="jogo_browser.html"><img src="imgs/jogos/jogo2.jpg" /></a></div>
            	            <div><a href="jogo_browser.html">Nome do jogo</a><br />Aventura | Browser Game<br /><strong>Nome do criador do jogo</strong><br />Jogado 10 vezes</div>
                	    </div>

	                    <!-- item -->
    	                <div class="itemJogos">
        	            	<div class="imgItemJogos"><a href="jogo_download.html"><img src="imgs/jogos/jogo3.jpg" /></a></div>
            	            <div><a href="jogo_download.html">Nome do jogo</a><br />Aventura | Para Download<br /><strong>Nome do criador do jogo</strong><br />Jogado 10 vezes</div>
                	    </div>                        

	                    <!-- item -->
    	                <div class="itemJogos">
        	            	<div class="imgItemJogos"><a href="jogo_browser.html"><img src="imgs/jogos/jogo4.jpg" /></a></div>
            	            <div><a href="jogo_browser.html">Nome do jogo</a><br />Aventura | Browser Game<br /><strong>Nome do criador do jogo</strong><br />Jogado 10 vezes</div>
                	    </div>

	                    <!-- item -->
    	                <div class="itemJogos">
        	            	<div class="imgItemJogos"><a href="jogo_browser.html"><img src="imgs/jogos/jogo5.jpg" /></a></div>
            	            <div><a href="jogo_browser.html">Nome do jogo</a><br />Aventura | Browser Game<br /><strong>Nome do criador do jogo</strong><br />Jogado 10 vezes</div>
                	    </div>

	                    <!-- item -->
    	                <div class="itemJogos">
        	            	<div class="imgItemJogos"><a href="jogo_download.html"><img src="imgs/jogos/jogo6.jpg" /></a></div>
            	            <div><a href="jogo_download.html">Nome do jogo</a><br />Aventura | Para Download<br /><strong>Nome do criador do jogo</strong><br />Jogado 10 vezes</div>
                	    </div>

	                    <!-- item -->
    	                <div class="itemJogos">
        	            	<div class="imgItemJogos"><a href="jogo_browser.html"><img src="imgs/jogos/jogo1.jpg" /></a></div>
            	            <div><a href="jogo_browser.html">Nome do jogo</a><br />Aventura | Browser Game<br /><strong>Nome do criador do jogo</strong><br />Jogado 10 vezes</div>
                	    </div>

	                    <!-- item -->
    	                <div class="itemJogos">
        	            	<div class="imgItemJogos"><a href="jogo_browser.html"><img src="imgs/jogos/jogo2.jpg" /></a></div>
            	            <div><a href="jogo_browser.html">Nome do jogo</a><br />Aventura | Browser Game<br /><strong>Nome do criador do jogo</strong><br />Jogado 10 vezes</div>
                	    </div>

	                    <!-- item -->
    	                <div class="itemJogos">
        	            	<div class="imgItemJogos"><a href="jogo_download.html"><img src="imgs/jogos/jogo3.jpg" /></a></div>
            	            <div><a href="jogo_download.html">Nome do jogo</a><br />Aventura | Para Download<br /><strong>Nome do criador do jogo</strong><br />Jogado 10 vezes</div>
                	    </div>                        

	                    <!-- item -->
    	                <div class="itemJogos">
        	            	<div class="imgItemJogos"><a href="jogo_browser.html"><img src="imgs/jogos/jogo4.jpg" /></a></div>
            	            <div><a href="jogo_browser.html">Nome do jogo</a><br />Aventura | Browser Game<br /><strong>Nome do criador do jogo</strong><br />Jogado 10 vezes</div>
                	    </div>

	                    <!-- item -->
    	                <div class="itemJogos">
        	            	<div class="imgItemJogos"><a href="jogo_browser.html"><img src="imgs/jogos/jogo5.jpg" /></a></div>
            	            <div><a href="jogo_browser.html">Nome do jogo</a><br />Aventura | Browser Game<br /><strong>Nome do criador do jogo</strong><br />Jogado 10 vezes</div>
                	    </div>

	                    <!-- item -->
    	                <div class="itemJogos">
        	            	<div class="imgItemJogos"><a href="jogo_download.html"><img src="imgs/jogos/jogo6.jpg" /></a></div>
            	            <div><a href="jogo_download.html">Nome do jogo</a><br />Aventura | Para Download<br /><strong>Nome do criador do jogo</strong><br />Jogado 10 vezes</div>
                	    </div>
                        
                    </div>

						<p class="paginacao">«<a href="#">Início</a> <a href="#">Anterior</a> <a href="#">1</a> <strong>2</strong> <a href="#">3</a> <a href="#">4</a> <a href="#">5</a> <a href="#">Próximo</a> <a href="#">Fim</a>»</p>

                </div>
                <img src="imgs/content_bot.png" align="top" />
                 
            </div>
            <!-- Coluna Direita -->
           
<?php
	include_once 'includes/lateralDireita.php';
	include_once 'includes/footer.php';
?>

			