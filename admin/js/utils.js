(function($){
	$(document).ready(function(){
		$("button").button();
	});
})(jQuery);

function verifyObrigatorio(){
	if(jQuery(".obrigatorio").length > 0){
		jQuery(".obrigatorio").removeClass('erro');
		var obj;
		var qtd = 0;
		jQuery(".obrigatorio").each(function(){
			obj = jQuery(this);
			if(jQuery.trim(obj.val())==''){
				obj.addClass("erro");
				qtd++;
			}
		});
		return (qtd > 0)?false:true;
	}else{
		return true;
	}
}
var newAlert = function(mensagem,tempo){
	tempo = (tempo == undefined) ? 400 : tempo;
	$.fx.speeds._default = tempo;
	jQuery('<div class="newAlert"></div>').dialog({
		'modal':true,
		'title':'A L E R T A',
		'show': "explode",
		'hide': 'explode',
		'buttons':{
			'OK':function(){
				$(this).dialog('destroy');
				window.setTimeout(function(){
					$(".newAlert").remove();
				},300);
			}
		}
	}).html(mensagem);
}


var newConfirm = function(mensagem,funcao,tempo){
	tempo = (tempo == undefined) ? 400 : tempo;
	$.fx.speeds._default = tempo;
	jQuery('<div class="newConfirm"></div>').dialog({
		'modal':true,
		'title':'A L E R T A',
		'show': "explode",
		'hide': 'explode',
		'buttons':{
			'Sim':function(){
				$(this).dialog('destroy');
				window.setTimeout(function(){
					$(".newConfirm").remove();
					var retorno = {
						'retorno': true
					};
					if(typeof(funcao)=="function"){
						funcao(true);
						//funcao(true);
					}
				},300);
			}
			,'Não':function(){
				$(this).dialog('destroy');
				window.setTimeout(function(){
					$(".newConfirm").remove();
					var retorno = {
						'retorno': false
					};
					if(typeof(funcao)=="function"){
						funcao(false);
					}
				},300);
			}
		}
	}).html(mensagem);
}

function empty (mixed_var) {
    // http://kevin.vanzonneveld.net
    // +   original by: Philippe Baumann
    // +      input by: Onno Marsman
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +      input by: LH
    // +   improved by: Onno Marsman
    // +   improved by: Francesco
    // +   improved by: Marc Jansen
    // +   input by: Stoyan Kyosev (http://www.svest.org/)
    // *     example 1: empty(null);
    // *     returns 1: true
    // *     example 2: empty(undefined);
    // *     returns 2: true
    // *     example 3: empty([]);
    // *     returns 3: true
    // *     example 4: empty({});
    // *     returns 4: true
    // *     example 5: empty({'aFunc' : function () { alert('humpty'); } });
    // *     returns 5: false
    var key;

    if (mixed_var === "" || mixed_var === 0 || mixed_var === "0" || mixed_var === null || mixed_var === false || typeof mixed_var === 'undefined') {
        return true;
    }

    if (typeof mixed_var == 'object') {
        for (key in mixed_var) {
            return false;
        }
        return true;
    }

    return false;
}

