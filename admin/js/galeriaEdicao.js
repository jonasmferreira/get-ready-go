function deleteImage(imagem_galeria_id){
	var bodyContent = jQuery.ajax({
		url: "controller/galeria.controller.php?action=deleteImagemGaleria",
		global: false,
		type: "POST",
		data: ({'imagem_galeria_id' : imagem_galeria_id}),
		dataType: "text",
		async:false
	}).responseText;
	newAlert(bodyContent);
}
(function($)
{
	$(document).ready(function(){
		$("#salvar").click(function(){
			if(!verifyObrigatorio()){
				newAlert("Campos marcados são obrigatórios");
			}else{
				$("#formSalvar").submit();
			}
		});
		$("#limparCadastro").click(function(){
			$("#formSalvar input[type=text], #formSalvar input[type=password]").val('');
			$("#formSalvar select option:first").attr('selected','selected');
		});
		
		$("#voltar").click(function(){
			window.location.href = 'galeria.php';
		});
		$(".delImage").live('click',function(){
			var obj = $(this);
			var imagem_galeria_id = obj.parent().find('input').val();
			if(empty(imagem_galeria_id)){
				obj.parent().parent().remove();
			}else{
				deleteImage(imagem_galeria_id);
			}
			
		});
		$("#addImage").click(function(){
			var obj = $(this);
			var td = new Array()
			td[0] = '<td><div class="icon-cancel delImage">&nbsp;</div><input type="hidden" name="imagem_galeria_id[]" value="" /></td>';
			td[1] = '<td><input type="text" name="imagem_galeria_titulo[]" /></td>';
			td[2] = '<td><input type="file" name="imagem_galeria_thumb[]" /></td>';
			td[3] = '<td><input type="file" name="imagem_galeria_imagem[]" /></td>';
			obj.parent().parent().parent().parent().find('tbody').append('<tr>'+td.join("\n")+'</tr>');
		});
		
	});
})(jQuery);