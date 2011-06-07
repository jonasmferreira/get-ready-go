$(document).ready(function(){
	$("#enviar_resetpassword").click(function(e){
		e.preventDefault();
		if($("#email_reset").val()==""){
			alert("Por favor insira o e-mail!");
			return false;
		}
		var arrLoader = new Array();
		arrLoader.push('<img src="'+$("#linkAbsolute").val()+'imgs/ajax-loader.gif" style="display:block; margin:auto" /><br clear="all" />')
		arrLoader.push('<div style="text-align:center !important">Enviando o e-mail!</div>');
		$("#respostaResetPassword").html(arrLoader.join("\n"));
		$.ajax({
			'type':'POST',
			'async':false,
			'url':$("#linkAbsolute").val()+"ajax/forgotpassword",
			'data':{
				'action':'resetPassword',
				'email_reset':$("#email_reset").val()
			},
			'success':function(resp){
				$("#respostaResetPassword").html(resp);
				$("#email_reset").val('');
			}
		});
	});
});