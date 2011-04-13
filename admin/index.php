<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="imagetoolbar" content="no" />
		<title>Administration Panel</title>
		<link media="screen" rel="stylesheet" type="text/css" href="css/admin-login.css"  />
		<link media="all" rel="stylesheet" type="text/css" href="js/css/redmond/jquery-ui-1.8.11.custom.css"  />
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/jquery-ui.js"></script>
		<script type="text/javascript" src="js/i18n/jquery.ui.datepicker-pt-BR.js"></script>
		<script type="text/javascript" src="js/funcoes.js"></script>
		<script type="text/javascript" src="js/index.js"></script>
		<!--[if lte IE 6]><link media="screen" rel="stylesheet" type="text/css" href="css/admin-login-ie.css" /><![endif]-->
	</head>
	<body>
		<!--[if !IE]>start wrapper<![endif]-->
		<div id="wrapper">
			<!--[if !IE]>start login wrapper<![endif]-->
			<div id="login_wrapper">
				<div class="error" id="erro_logon">
					<div class="error_inner" id="erro_logon_message">
						<strong>Acesso Negado</strong> | <span>Login/Senha incorretos</span>
					</div>
				</div>
				<!--[if !IE]>start login<![endif]-->
				<form action="#">
					<fieldset>
						<h1 id="logo"><a href="#">websitename Administration Panel</a></h1>
						<div class="formular">
							<div class="formular_inner">
								<label>
									<strong>Login:</strong>
									<span class="input_wrapper"><input name="login" id="login" type="text" class="obrigatory" /></span>
								</label>
								<label>
									<strong>Senha:</strong>
									<span class="input_wrapper"><input name="pass" id="pass" type="password" /></span>
								</label>
								<ul class="form_menu">
									<li><span class="button"><span><span>Submit</span></span><input type="submit" id="enviar" name=""/></span></li>
									<li><a href="#"><span><span>Back</span></span></a></li>
									<li><a href="#"><span><span>Forgot Pass</span></span></a></li>
								</ul>
							</div>
						</div>
					</fieldset>
				</form>
				<!--[if !IE]>end login<![endif]-->
			</div>
			<!--[if !IE]>end login wrapper<![endif]-->
		</div>
		<!--[if !IE]>end wrapper<![endif]-->
	</body>
</html>
