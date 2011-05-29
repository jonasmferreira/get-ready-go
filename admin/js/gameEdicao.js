
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
		
	});
})(jQuery);