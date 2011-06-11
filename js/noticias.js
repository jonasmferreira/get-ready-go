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
		if($("#usuario_id").val()==0){
			if($("#captcha").val().length==0){
				alert("Por favor insira o captcha!!");
				return false;
			}
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
				}else{
					window.location.href = window.location.href;
				}
			}
		});
	});

	$('.anterior').click(function(){
		 $(".paginacao a.ativoPaginacao").prev().trigger("click");
	});
	$('.proximo').click(function(){
		console.log($(".paginacao a.ativoPaginacao").next())
		$(".paginacao a.ativoPaginacao").next().trigger("click");
	});
	$('.inicio').click(function(){
		$(".paginacao a.paginacaoPage").fadeIn();
		$(".paginacao a.paginacaoPage").first().trigger("click");
	});
	$('.fim').click(function(){
		$(".paginacao a.paginacaoPage").fadeIn();
		$(".paginacao a.paginacaoPage").last().trigger("click");
	});
	$(".paginacaoPage:not(:.ativoPaginacao)").live('click',function(e){
		$(this).stop(true, true);
		var obj = $(this);
		var idAtivo = $(".paginacao a.ativoPaginacao").attr('id').split("_").pop();
		obj.next().fadeIn();
		$(".paginacao a").removeClass("ativoPaginacao");
		obj.addClass("ativoPaginacao");
		var paginacao = obj.context.id.split("_").pop();
		var pagePaginacao = $("#listagem_"+""+paginacao);
		if(pagePaginacao.html()==null){
			$.ajax({
				'type':'POST',
				'async':false,
				'url':$("#linkAbsolute").val()+'ajax/ajaxPaginacao',
				'dataType':'html',
				'data':{
					'action':'comentarios',
					'post_id':$("#post_id").val(),
					'limit':paginacao
				},
				success:function(resp){
					resp = resp.replace(/@LINKABSOLUTO@/g, $("#linkAbsolute").val());
					$("#listagem_"+idAtivo).fadeOut('fast',function(){
						pagePaginacao.fadeIn();
						$("#listagem").append(resp);
					});
				}
			});
		}else{
			$("#listagem_"+idAtivo).fadeOut('fast',function(){
				pagePaginacao.fadeIn('slow');
			});
		}
	});
	$("#comentario").bind('keyup keydown',function(){
		var total = 1000;
		if($(this).val().length==1000){
			return false;
		}
		$(".qtdCaracteres").text(total-($.trim($(this).val().length)));
	})
	$("#feedRss").click(function(e){
		e.preventDefault();
		console.log("opa");
		window.location.href = $("#linkAbsolute").val()+"rss/rss_noticias";
	});
});
var emoticon = function(text){
	$("#comentario").val($("#comentario").val()+" "+text)
}
var newCaptcha = function(){
	$("#imageCaptcha").attr('src',$("#linkAbsolute").val()+"captcha.php?sid="+Math.random());
	return true;
}