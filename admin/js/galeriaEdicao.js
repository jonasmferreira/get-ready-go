(function($){
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
		
	});
})(jQuery);