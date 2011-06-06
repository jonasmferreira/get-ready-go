<div class="custom">
	<div id="all">
    	<!-- Topo -->
        <div id="topo">
        	<div id="logo"><a href="index.html"><img src="<?php echo $linkAbsolute ?>imgs/logo.png" /></a></div>
            <!-- Área de usuários -->
            <div id="user">
            	<!-- Login -->
                Usuário <input type="text" class="login" />
                Senha <input type="text" class="login" /> <input type="image" src="<?php echo $linkAbsolute ?>imgs/login.png" align="absbottom" /><br />
				<a href="<?php echo $linkAbsolute ?>forgotpassword">Esqueceu sua senha?</a>
                <a href="<?php echo $linkAbsolute ?>cadastro">Cadastre-se</a>

                <!-- Logado -->
                <!--
                <div style="float:right; margin:0 0 0 10px"><img src="<?php echo $linkAbsolute ?>imgs/avatares/1.jpg" class="avatar" /></div>
                <div style="float:right; padding:31px 0 0 0">Bem vindo, <strong>Fulano de tal</strong><br />
				<a href="perfil.html">Meu perfil</a> | <a href="#">Sair</a></div> -->
            </div>
            <!-- Busca -->
            <div id="search">
            	<table cellpadding="0" cellspacing="0" border="0">
                	<tr>
                    	<td><input type="text" class="busca" align="top" /></td>
                        <td><input type="image" src="<?php echo $linkAbsolute ?>imgs/bt_go.gif" /></td>
                    </tr>
                </table>
            </div>
            <!-- Menu -->
        	<?php include_once 'menu.php'; ?>
        </div>
		<!-- Conteudo -->
        <div id="miolo">