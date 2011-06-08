$(document).ready(function(){

	$('.avalia').raty({
		half: true,
		path:$("#linkAbsolute").val()+"js/img",
		start: 0,
		click: function(score, evt) {
			$.fn.raty.readOnly(true, '.avalia');
			$.ajax({
				'type':'POST',
				'async':false,
				'url':$("#linkAbsolute").val()+'ajax/game',
				'dataType':'json',
				'data':{
					'action':'avaliacao',
					'game_id':$("#game_id").val(),
					'pontuacao':score
				},
				success:function(resp){
					if(resp.success==false){
						window.location.href = window.location.href;
					}
				}
			});
		}
	});

	$('#avaliado').raty({
		half: true,
		path:$("#linkAbsolute").val()+"js/img",
		start: $("#pontuacao").val(),
		readOnly:  true
	});

	$("#somaDownload").live('click',function(e){
		//e.preventDefault()
		$.ajax({
			'type':'POST',
			'async':false,
			'url':$("#linkAbsolute").val()+'ajax/game',
			'dataType':'json',
			'data':{
				'action':'somaDownload',
				'game_id':$("#game_id").val()
			},
			success:function(resp){
				if(resp.success==false){
					window.location.href = window.location.href;
				}
			}
		});
	});
});