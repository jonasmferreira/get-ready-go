(function($){
	$(document).ready(function(){

		$("#salvar").click(function(){
			if(!verifyObrigatorio()){
				newAlert("Campos marcados são obrigatórios");
			}else{
				$("#formSalvar").submit();
			}
		});

		$(".somenteNumero").bind('keyup keydown',function(){
			var valor = $(this).val().replace(/\D/,'');
			$(this).val(valor);
		});
		

		$("#limparCadastro").click(function(){
			$("#formSalvar input[type=text], #formSalvar input[type=password]").val('');
			$("#formSalvar select option:first").attr('selected','selected');
		});

		$("#voltar").click(function(){
			window.location.href = 'publicidadeTipo.php';
		});

	});
})(jQuery);