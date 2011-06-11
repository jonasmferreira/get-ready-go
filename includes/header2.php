<?
	$bgDoidao = '';
	if(is_array($aBgBanner) && count($aBgBanner)>0){
		foreach($aBgBanner as $k => $v){
			$link = $v['publicidade_link'];
			$arq = $linkAbsolute . 'publicidade/' . $v['publicidade_arquivo'];
			$w = $v['publicidade_largura'];
			$h = $v['publicidade_altura'];

			if($v['publicidade_tipomedia']==0){ 
				$bgDoidao = "style=\"background-color:{$arq}\"";
			}
		}
	}
?>
<div class="custom" <?php echo $bgDoidao ?>>
	<div id="all">
    	<!-- Topo -->
        <div id="topo">
        	<div id="logo">
				<a href="<?php echo $linkAbsolute ?>/index.php"><img src="<?php echo $linkAbsolute ?>imgs/logo.png" /></a>
			</div>
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
						<?php
							if(@file_get_contents("{$linkAbsolute}avatars/{$_SESSION['GET_READY_GO_2011_SITE']['usuario_avatar']}")==true){
								$file = "{$linkAbsolute}avatars/{$_SESSION['GET_READY_GO_2011_SITE']['usuario_avatar']}";
							}else{
								$file = "{$linkAbsolute}avatar_user/{$_SESSION['GET_READY_GO_2011_SITE']['usuario_avatar']}";
							}
						?>
						<img src="<?php echo "{$file}" ?>" class="avatar" />
						<?php } ?>
					</div>
					<div style="float:right; padding:31px 0 0 0">Bem vindo, <strong class="nomeSobrenome"><?php echo $_SESSION['GET_READY_GO_2011_SITE']['usuario_nome'] ?></strong><br />
					<a href="<?php echo $linkAbsolute ?>meu_perfil">Meu perfil</a> | <a href="javascript:void(0)" id="logoff">Sair</a></div>
				</div>
				<?php #echo "<pre>".print_r($_SESSION['GET_READY_GO_2011_SITE']['usuario_id'],true)."</pre>"; ?>
            </div>
            <!-- Busca -->
            <div id="search">
            	<form id="frmbusca" action="<?php echo $linkAbsolute ?>/busca_result.php" method="post">
					<table cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td><input type="text" class="busca" align="top" name="busca" id="busca" value="<?=$_POST['busca']?>" /></td>
							<td>
								<input type="image" src="<?php echo $linkAbsolute ?>imgs/bt_go.gif" id="button_busca" />
							</td>
						</tr>
					</table>
				</form>
            </div>
            <!-- Menu -->
        	<?php include_once 'menu.php'; ?>
        </div>
		<?php if(is_array($aFullBanner) && count($aFullBanner)>0){ ?>
        <!-- Publicidade - banner 728x90 -->
        <div id="fullBanner">
	        publicidade <img src="<?php echo $linkAbsolute ?>imgs/seta.gif" align="bottom" /><br />
			<div>
				<? 
					foreach($aFullBanner as $k => $v){
						$link = $v['publicidade_link'];
						$arq = $linkAbsolute . 'publicidade/' . $v['publicidade_arquivo'];
						$w = $v['publicidade_largura'];
						$h = $v['publicidade_altura'];

						if($v['publicidade_tipomedia']==0){ 
				?>
							<a href="<?=$link;?>" target="_blank"><img src="<?=$arq;?>" width="<?=$w;?>"  height="<?=$h;?>" /></a>			
				<?		} else { ?>
							<script type="text/javascript">buildFlash('<?=$arq;?>','<?=$w;?>','<?=$h;?>','opaque');</script> 
				<?		} 
					}
				?>
			</div>
		<?php } ?>
        </div>
		<!-- Conteudo -->
        <div id="miolo">