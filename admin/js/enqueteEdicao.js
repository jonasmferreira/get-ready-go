function deleteOpcao(enquete_opcao_id){
	var bodyContent = jQuery.ajax({
		url: "controller/enquete.controller.php?action=deleteOpcaoEnquete",
		global: false,
		type: "POST",
		data: ({'enquete_opcao_id' : enquete_opcao_id}),
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
			window.location.href = 'enquete.php';
		});
		$(".delOpcao").live('click',function(){
			var obj = $(this);
			var enquete_opcao_id = obj.parent().find('input').val();
			if(empty(enquete_opcao_id)){
				obj.parent().parent().remove();
			}else{
				deleteOpcao(enquete_opcao_id);
			}
			
		});
		$("#addOpcao").click(function(){
			var obj = $(this);
			var td = new Array()
			td[0] = '<td><div class="icon-cancel delOpcao">&nbsp;</div><input type="hidden" name="enquete_opcao_id[]" value="" /></td>';
			td[1] = '<td><input type="text" name="enquete_opcao_titulo[]" /></td>';
			td[3] = '<td>0</td>';
			obj.parent().parent().parent().parent().find('tbody').append('<tr>'+td.join("\n")+'</tr>');
		});
		
	});
})(jQuery);