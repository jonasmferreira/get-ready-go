function checkMail(mail){
	var er = new RegExp(/^[A-Za-z0-9_\-\.]+@[A-Za-z0-9_\-\.]{2,}\.[A-Za-z0-9]{2,}(\.[A-Za-z0-9])?/);
	if(er.test(mail)){ 
		return true; 
	}else{
		return false;
	}
}

function verifyLogin(obj){
	if($.trim(obj.val())==""){
		alert("Por favor insira o login!");
		return false;
	}
	$.ajax({
		'type':'POST',
		'async':false,
		'url':$("#linkAbsolute").val()+"ajax/cadastro",
		'data':{
			'action':'verifyLogin'
			,'usuario_login':obj.val()
		},
		'success':function(resp){
			if($.trim(resp)!='CMD_SUCCESS'){
				$("#respostacadastra_usuario").html(resp);
				obj.val('');
			}else{
				$("#respostacadastra_usuario").html('');
			}
			
		}
	});
}
function verifyEmail(obj){
	if(!checkMail(obj.val())){
		alert("Por favor insira o e-mail!");
		return false;
	}
	$.ajax({
		'type':'POST',
		'async':false,
		'url':$("#linkAbsolute").val()+"ajax/cadastro",
		'data':{
			'action':'verifyEmail'
			,'usuario_email':obj.val()
		},
		'success':function(resp){
			if($.trim(resp)!='CMD_SUCCESS'){
				$("#respostacadastra_usuario").html(resp);
				obj.val('');
			}else{
				$("#respostacadastra_usuario").html('');
			}
		}
	});
}
$(document).ready(function(){
	$("#login_cad").blur(function(){
		verifyLogin($(this));
	});
	$("#email_cad").blur(function(){
		verifyEmail($(this));
	});
	$("#cadastra_usuario").click(function(e){
		e.preventDefault();
		if($.trim($("#usuario_cad").val())==""){
			alert("Por favor insira o nome do usuário!");
			return false;
		}
		if($.trim($("#login_cad").val())==""){
			alert("Por favor insira o login!");
			return false;
		}
		if(!checkMail($("#email_cad").val())){
			alert("Por favor insira o e-mail!");
			return false;
		}
		if($.trim($("#senha_cad").val())==""){
			alert("Por favor insira a senha!");
			return false;
		}
		var usuario_nome = $.trim($("#usuario_cad").val());
		var usuario_login = $.trim($("#login_cad").val());
		var usuario_email = $.trim($("#email_cad").val());
		var usuario_senha = $.trim($("#senha_cad").val());
		var arrLoader = new Array();
		arrLoader.push('<img src="'+$("#linkAbsolute").val()+'imgs/ajax-loader.gif" style="display:block; margin:auto" /><br clear="all" />')
		arrLoader.push('<div style="text-align:center !important">Cadastrando Usuário...</div>');
		$("#respostacadastra_usuario").html(arrLoader.join("\n"));
		$.ajax({
			'type':'POST',
			'async':false,
			'url':$("#linkAbsolute").val()+"ajax/cadastro",
			'data':{
				'action':'cadastro'
				,'usuario_nome':usuario_nome
				,'usuario_login':usuario_login
				,'usuario_senha':usuario_senha
				,'usuario_email':usuario_email
			},
			'success':function(resp){
				$("#respostacadastra_usuario").html(resp);
				$("#usuario").val('');
				$("#email").val('');
				$("#senha").val('');
			}
		});
	});
});