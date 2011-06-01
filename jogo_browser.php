<?php
	include_once 'includes/cabecalho.php';
	include_once 'includes/header.php';
?>
        	<!-- Jogo -->
            <img src="imgs/full_content_top.png" align="absbottom" />
            <div id="conteudo" class="gameArea">
				<!-- nome da seção -->
				<h2><b class="title">browser game</b></h2>
                   
            	<!-- Conteúdo do Artigo -->
                <h1>Nome do jogo</h1>
                
                <!-- Área do jogo -->
                <div align="center">
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="800" height="590" border="0"><param name="allowScriptAccess" value="sameDomain"/><param name="movie" value="http://haznos.org/wp-content/uploads/2011/03/charlie.swf"/><embed src="http://haznos.org/wp-content/uploads/2011/03/charlie.swf" width="800" height="590" allowscriptaccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"/></embed></object>
            	</div>
            
            </div>
            <img src="imgs/full_content_bot.png" align="absbottom" />
        
        	<!-- Coluna Esquerda -->
            <div id="leftCol">
            
                <!-- Conteúdo -->
                <img src="imgs/content_top.png" align="absbottom" />
                <div id="conteudo">
                   
                    <!-- Conteúdo do Artigo -->
                    
                    <div id="newsContent">

                    	<div class="newsHeader">
                        	<p class="data">Criado por</p>
                            <div style="float:left; width:62px;"><a href="perfil.html"><img src="imgs/avatares/05.jpg" style="width:60px;border:1px solid #000;" /></a></div>
                            <div style="float:left; margin:15px 5px 5px 5px">
                            	<h3><a href="perfil.html">Fulano de Tal</a></h3> <!-- Sem link se o autor não for usuário cadastrado -->
                                <p><a href="busca.html">veja mais jogos desse autor</a></p>
                            </div><div style="clear:both"></div>
                        </div>

                        <!-- Texto -->
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas nunc justo, dapibus in placerat non, sollicitudin nec magna. Suspendisse venenatis dui in ipsum tristique consequat. Quisque sit amet turpis eget velit tincidunt blandit sed id nisi. Aliquam erat volutpat. Donec sollicitudin libero sed ligula iaculis sed tincidunt ligula porta. Fusce at nunc tellus. Integer egestas dictum enim eu pellentesque. Aliquam erat volutpat. Sed tincidunt turpis non risus ultrices fermentum. Phasellus facilisis sollicitudin consequat. Praesent sed elit libero, rutrum volutpat lorem. Duis lacinia malesuada pulvinar. </p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas nunc justo, dapibus in placerat non, sollicitudin nec magna. Suspendisse venenatis dui in ipsum tristique consequat. Quisque sit amet turpis eget velit tincidunt blandit sed id nisi. Aliquam erat volutpat. Donec sollicitudin libero sed ligula iaculis sed tincidunt ligula porta. Fusce at nunc tellus. Integer egestas dictum enim eu pellentesque. Aliquam erat volutpat. Sed tincidunt turpis non risus ultrices fermentum. Phasellus facilisis sollicitudin consequat. Praesent sed elit libero, rutrum volutpat lorem. Duis lacinia malesuada pulvinar. </p>
                    
                    </div>
                    
                </div>
                <img src="imgs/content_bot.png" align="top" />
                 
            </div>
            <!-- Coluna Direita -->
            <div id="rightCol">

				<!-- Estatísticas -->
                <img src="imgs/box_top.png" align="absbottom" />
                <div id="rightBox" class="stats">
	                <h2><b class="title">Estatísticas</b></h2>
			        <table cellspacing="5" width="100%" border="0" cellpadding="0">
						<tr>
                    		<td align="center">Avaliação geral:<br /><img src="imgs/nota_09.jpg" /></td>
                        	<td align="center">Sua avaliação:<br />
                        		<div class="avalia">
					                <a href="#">&nbsp;</a>
    	        				    <a href="#">&nbsp;</a>
        	                		<a href="#">&nbsp;</a>
				            	    <a href="#">&nbsp;</a>
                					<a href="#">&nbsp;</a>
         						</div>
                        	</td>
                        </tr>
                        <tr>
		                	<td colspan="2" align="center">Jogado: <strong>999999</strong> vezes</td>
                    	</tr>
                	</table>
                </div>
                <img src="imgs/box_bot.png" align="top" style="clear:both" />

            	<!-- Banner 300x250 -->
            	<div id="sideBanner"><img src="banners/banner_300x250.jpg" /></div>

            </div>
<?php
	include_once 'includes/footer.php';
?>