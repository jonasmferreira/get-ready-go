$(document).ready(function(){
	$("#enviarComentario").click(function(e){
		e.preventDefault();
		if($("#nome").val()==""){
			alert("Por favor insira um nome!");
			return false;
		}
		if($("#comentario").val().length==0){
			alert("Por favor insira uma mensagem!!");
			return false;
		}
		if($("#captcha").val().length==0){
			alert("Por favor insira o captcha!!");
			return false;
		}
		$.ajax({
			'type':'POST',
			'async':false,
			'url':$("#linkAbsolute").val()+"ajax/noticias",
			'dataType':'json',
			'data':{
				'action':'addComentario',
				'nome':$("#nome").val(),
				'comentario':$("#comentario").val(),
				'captcha':$("#captcha").val(),
				'usuario_id':$("#usuario_id").val(),
				'post_id':$("#post_id").val()
			},
			'success':function(resp){
				alert(resp.message);
				if(resp.success==false){
					newCaptcha();
				}
			}
		});
	});
});
var emoticon = function(text){
	$("#comentario").val($("#comentario").val()+" "+text)
}
var newCaptcha = function(){
	$("#imageCaptcha").attr('src',$("#linkAbsolute").val()+"captcha.php?sid="+Math.random());
	return true;
}