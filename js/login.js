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
					if(resp.session.usuario_avatar!=''){
						$(".avatar").attr("src",$("#linkAbsolute").val()+"avatars/"+resp.session.usuario_avatar);
					}else{
						$(".avatar").attr("src",$("#linkAbsolute").val()+"imgs/avatares/1.jpg");
					}
					$(".nomeSobrenome").text(resp.session.usuario_nome);
					$("#logado-se").fadeOut(function(){
						$("#logado").fadeIn()
					});
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
				$("#logado").fadeOut(function(){
					$("#logado-se").fadeIn()
				});
			}
		});
	});

});