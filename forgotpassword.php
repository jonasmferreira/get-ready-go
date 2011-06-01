<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Get Ready... Go!</title>
<link href="style.css" media="screen" rel="stylesheet" type="text/css" />
</head>

<body>
<div>
	<div id="all">
    	<!-- Topo -->
        <div id="topo">
        	<div id="logo"><a href="index.html"><img src="imgs/logo.png" /></a></div>
            <!-- Área de usuários -->
            <div id="user">
            	<!-- Login -->
                Usuário <input type="text" class="login" />
                Senha <input type="text" class="login" /> <input type="image" src="imgs/login.png" align="absbottom" /><br />
				<a href="forgotpassword.html">Esqueceu sua senha?</a>
                <a href="cadastro.html">Cadastre-se</a>

                <!-- Logado -->
                <!--
                <div style="float:right; margin:0 0 0 10px"><img src="imgs/avatares/1.jpg" class="avatar" /></div>
                <div style="float:right; padding:31px 0 0 0">Bem vindo, <strong>Fulano de tal</strong><br /> 	
				<a href="perfil.html">Meu perfil</a> | <a href="#">Sair</a></div> -->
            </div>
            <!-- Busca -->
            <div id="search">
            	<table cellpadding="0" cellspacing="0" border="0">
                	<tr>
                    	<td><input type="text" class="busca" align="top" /></td>
                        <td><input type="image" src="imgs/bt_go.gif" /></td>
                    </tr>
                </table>
            </div>
            <!-- Menu -->
        	<div id="menu">
            	<ul>
                	<li><a href="index.html">home</a></li>
                	<li><a href="listanoticias.html">notícias</a></li>
                	<li><a href="listanoticias.html">artigos</a></li>
                	<li><a href="listanoticias.html">análises</a></li>
                	<li><a href="listajogos.html">indiecamos</a></li>
                </ul>
            </div>
        </div>
        <!-- Conteudo -->
        <div id="miolo">
           
            <!-- Conteúdo -->
			<img src="imgs/content_top.png" align="absbottom" style="display:block; margin:auto" />
            <div id="conteudo" class="sistema">
				<!-- Últimas Notícias -->
				<h2><b class="title">esqueceu sua senha?</b></h2>
                <p align="center">Escreva seu endereço de e-mail no espaço abaixo e clique em "enviar".</p>
                <p align="center">
                	<table align="center">
                    	<tr>
                        	<td><strong>Endereço de e-mail</strong></td>
                            <td><input type="text" class="text" size="50" /></td>
                            <td><input type="image" src="imgs/bt_enviar.gif" /></td>
                        </tr>
                    </table>
                </p>
                <p align="center">Enviaremos um e-mail com instruções de como resetar sua senha.</p>
				<p align="center" class="green"><strong>E-mail enviado com sucesso!</strong></p><!-- Mensagem de sucesso -->
				<p align="center" class="red"><strong>Falha no envio, tente outra vez mais tarde.</strong></p><!-- Mensagem de erro -->
            </div>
            <img src="imgs/content_bot.png" align="top"  style="display:block; margin:auto; clear:both" />
        
        </div>
    </div>
</div>
</body>
</html>
