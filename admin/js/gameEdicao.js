
function getUsuario(usuario_id){
	var resp = jQuery.ajax({
		type: "POST"
		,async:false
		,url: "controller/game.controller.php?action=getUsuarioNome"
		,data: {
			'usuario_id': usuario_id
		}
	}).responseText;
	return resp;
}

(function($){
	$(document).ready(function(){

		$('#game_descricao').ckeditor();

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
		
		$("#usuario_id").change(function(){
			var usuario_id = $(this).val();
			if(usuario_id!='outro'&&usuario_id!=''){
				$("#game_criador_nome").val(getUsuario(usuario_id));
			}
		});
		
		$("#voltar").click(function(){
			window.location.href = 'game.php';
		});
		
		$("#game_categoria_id").change(function(){
			if($(this).val()==1){
				$("#game_midia_id").attr('disabled', 'disabled');
				$("#game_width").attr('disabled', 'disabled');
				$("#game_height").attr('disabled', 'disabled');
				$("#game_midia_id").removeClass('obrigatorio');
				$("#game_width").removeClass('obrigatorio');
				$("#game_height").removeClass('obrigatorio');
				
				$("#game_midia_id").val(1);
				$("#game_width").val(0);
				$("#game_height").val(0);
			}else{
				$("#game_midia_id").attr('disabled', '');
				$("#game_width").attr('disabled', '');
				$("#game_height").attr('disabled', '');
				$("#game_midia_id").addClass('obrigatorio');
				$("#game_width").addClass('obrigatorio');
				$("#game_height").addClass('obrigatorio');
				
			}
		});
		$("#game_categoria_id").trigger('change');
		
		
		
		
	});
})(jQuery);