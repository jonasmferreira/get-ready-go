var erros = new Array();
erros[0] = "Login/Senha incorretos";
erros[1] = "Preencha um Valor Válido";

(function($){
	$(document).ready(function(){
		jQuery("#erro_logon").css({
			'display':'none'
		});
		$("#enviar").click(function(e){
			e.preventDefault();
			$("#erro_logon").css({
				'display':'none'
			});
			if(!verifyObrigatory()){
				$("#erro_logon").css({
					'display':'block'
				});
				$("#erro_logon_message span").html(erros[1]);
			}else{
				newAlert("opa");
			}
		});
	});
})(jQuery);

