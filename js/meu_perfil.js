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
function teste(){
	console.log($("iframe"))
	//var frame = $("iframe")[0].contentDocument;
	/*$(".selectAvatar", frame).click(function(){
		alert('asasas')
	})*/
}
$(document).ready(function(){
	
	$("#newAvatar").colorbox({
		width:"685px",
		height:"600px",
		iframe:true,
		close: "Fechar",
		overlayClose: false,
		onClosed:function(){
			window.location.href = window.location.href;
		}
		,onComplete:function(){
			window.setTimeout(function(){
				var frame = $("iframe")[0].contentDocument;
				$(".selectAvatar", frame).click(function(){
					var usuario_avatar = $(this).parent().parent().parent().attr("id");
					$.ajax({
						'type':'POST',
						'async':false,
						'url':$("#linkAbsolute").val()+"ajax/meu_perfil",
						'data':{
							'action':'alteraAvatar'
							,'usuario_avatar':usuario_avatar
						},
						'success':function(resp){
							alert(resp);
							$("#cboxClose").trigger("click");
						}
					});
				})
				$(".imagem", frame).click(function(){
					$(".imagem", frame).css("border-color","transparent").removeClass("imagemSeletion")
					$("input", frame).attr("disabled","disabled")
					$(this).css("border-color","#F00").addClass("imagemSeletion");
					$(this).parent().find("input").removeAttr("disabled");
				})
			},300);
		}
	});
	
	$("#email").blur(function(){
		verifyEmail($(this));
	});
	$("#salvar").click(function(e){
		e.preventDefault();
		if($.trim($("#nome").val())==""){
			alert("Por favor insira o nome!");
			return false;
		}
		if(!checkMail($("#email").val())){
			alert("Por favor insira o e-mail!");
			return false;
		}
		if($.trim($("#pais").val())==""){
			alert("Por favor insira o país!");
			return false;
		}
		if($.trim($("#cidade").val())==""){
			alert("Por favor insira a cidade!");
			return false;
		}
		if($.trim($("#sexo").val())==""){
			alert("Por favor insira seu sexo!");
			return false;
		}
		if($("#meuperfil").val().length==0){
			alert("Por favor insira sobre!");
			return false;
		}
		var usuario_nome = $.trim($("#nome").val());
		var usuario_email = $.trim($("#email").val());
		var pais = $.trim($("#nome").val());
		var cidade = $.trim($("#email").val());
		var dataNascimento = $("#ano").val()+"-"+$("#mes").val()+"-"+$("#dia").val();
		var meuperfil = $.trim($("#meuperfil").val());
		var sexo = $.trim($("#sexo").val());
		var arrLoader = new Array();
		arrLoader.push('<img src="'+$("#linkAbsolute").val()+'imgs/ajax-loader.gif" style="display:block; margin:auto" /><br clear="all" />')
		arrLoader.push('<div style="text-align:center !important">Alterando Perfil...</div>');
		$("#respostacadastra_usuario").html(arrLoader.join("\n"));
		$.ajax({
			'type':'POST',
			'async':false,
			'url':$("#linkAbsolute").val()+"ajax/meu_perfil",
			'data':{
				'action':'savePerfil'
				,'usuario_nome':usuario_nome
				,'usuario_email':usuario_email
				,'usuario_country':pais
				,'usuario_city':cidade
				,'usuario_birthdate':dataNascimento
				,'usuario_gender':sexo
				,'usuario_perfil':meuperfil
			},
			'success':function(resp){
				$("#respostacadastra_usuario").html(resp);
			}
		});
	});
});