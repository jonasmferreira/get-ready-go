<div class="custom" style="background-image:url(<?php echo "{$linkAbsolute}"?>imgs/custom_bg/01.jpg);">
	<div id="all">
    	<!-- Topo -->
        <div id="topo">
        	<div id="logo"><a href="index.html"><img src="<?php echo $linkAbsolute ?>imgs/logo.png" /></a></div>
            <!-- Área de usuários -->
            <div id="user">
            	<!-- Login -->
				<div id="logado-se" style="<?php echo (!isset($_SESSION['GET_READY_GO_2011_SITE']['usuario_id']) && empty($_SESSION['GET_READY_GO_2011_SITE']['usuario_id']) )?'display:block':'display:none' ?>">
					Usuário <input type="text" class="login" id="login" />
					Senha <input type="password" class="login" id="password" />
					<input type="image" src="<?php echo $linkAbsolute ?>imgs/login.png" align="absbottom" id="logar" />
					<br />
					<a href="<?php echo $linkAbsolute ?>forgotpassword">Esqueceu sua senha?</a>
					<a href="<?php echo $linkAbsolute ?>cadastro">Cadastre-se</a>
				</div>

                <!-- Logado -->
				<div id="logado" style="<?php echo (!isset($_SESSION['GET_READY_GO_2011_SITE']['usuario_id']) && empty($_SESSION['GET_READY_GO_2011_SITE']['usuario_id']) )?'display:none':'display:block' ?>">
					<div style="float:right; margin:0 0 0 10px">
						<?php if($_SESSION['GET_READY_GO_2011_SITE']['usuario_avatar']==''){ ?>
						<img src="<?php echo $linkAbsolute ?>imgs/avatares/1.jpg" class="avatar" />
						<?php }else{ ?>
						<img src="<?php echo "{$linkAbsolute}avatars/{$_SESSION['GET_READY_GO_2011_SITE']['usuario_avatar']}" ?>" class="avatar" />
						<?php } ?>
					</div>
					<div style="float:right; padding:31px 0 0 0">Bem vindo, <strong class="nomeSobrenome"><?php echo $_SESSION['GET_READY_GO_2011_SITE']['usuario_nome'] ?></strong><br />
					<a href="perfil.html">Meu perfil</a> | <a href="javascript:void(0)" id="logoff">Sair</a></div>
				</div>
				<?php #echo "<pre>".print_r($_SESSION['GET_READY_GO_2011_SITE']['usuario_id'],true)."</pre>"; ?>
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
        <!-- Publicidade - banner 728x90 -->
        <div id="fullBanner">
	        publicidade <img src="<?php echo $linkAbsolute ?>imgs/seta.gif" align="bottom" /><br />
			<div><img src="<?php echo $linkAbsolute ?>banners/banner_728x90.jpg" /></div>
        </div>
		<!-- Conteudo -->
        <div id="miolo">