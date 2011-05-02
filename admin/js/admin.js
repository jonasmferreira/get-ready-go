(function($){
	$(document).ready(function(){
		$("#logoff").click(function(e){
			e.preventDefault();
			newConfirm('Deseja realmente sair',function(retorno){
				if(retorno!==false){
					window.location.href="controller/index.controller.php?action=logoff";
				}
			});
		});
	});
})(jQuery);