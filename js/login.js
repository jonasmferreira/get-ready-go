$(document).ready(function(){
	$("#logar").click(function(e){
		e.preventDefault();
		if($("#login").val()==""){
			alert("Por favor insira o login!");
			return false;
		}
		if($("#password").val()==""){
			alert("Por favor insira a senha!");
			return false;
		}
		$.ajax({
			'type':'POST',
			'async':false,
			'url':$("#linkAbsolute").val()+"ajax/login",
			'dataType':'json',
			'data':{
				'action':'logar',
				'password':$("#password").val(),
				'login':$("#login").val()
			},
			'success':function(resp){
				if(resp.success===false){
					alert("Usuario e senha incorretos!");
				}else{
					window.location.href = window.location.href;
				}
			}
		});
	});

	$("#logoff").click(function(){
		if(!confirm("Deseja realmente sair?")){
			return false;
		}
		$.ajax({
			'type':'POST',
			'async':false,
			'url':$("#linkAbsolute").val()+"ajax/login",
			'dataType':'json',
			'data':{
				'action':'logoff'
			},
			'success':function(resp){
				window.location.href = $("#linkAbsolute").val()+"index"
			}
		});
	});

});