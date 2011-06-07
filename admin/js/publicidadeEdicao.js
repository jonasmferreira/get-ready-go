(function($){
	$(document).ready(function(){

		$("#salvar").click(function(){
			if(!verifyObrigatorio()){
				newAlert("Campos marcados são obrigatórios");
			}else{
				$("#formSalvar").submit();
			}
		});

		$(".data").setMask('date-time').datepicker();

		$("#limparCadastro").click(function(){
			$("#formSalvar input[type=text], #formSalvar input[type=password]").val('');
			$("#formSalvar select option:first").attr('selected','selected');
		});

		$("#voltar").click(function(){
			window.location.href = 'publicidade.php';
		});
		
		$("#publicidade_tipomedia").change(function(){
			if($(this).val()==0){
				$("#publicidade_link").attr('disabled', '');
				$("#publicidade_link").addClass('obrigatorio');
			}else{
				$("#publicidade_link").attr('disabled', 'disabled');
				$("#publicidade_link").removeClass('obrigatorio');
			}
		});
		$("#publicidade_tipomedia").trigger('change');

	});
})(jQuery);