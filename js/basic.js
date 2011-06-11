function buildFlash(swfLocation,x,y,swfMode, variaveis){
	var swfLocation, x, y, swfMode, variaveis;
	if(variaveis == undefined || variaveis.length < 1) variaveis = '';
	document.write(' <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="'+x+'" height="'+y+'">');
	document.write(' <param name="movie" value="'+swfLocation+variaveis+'" />');
	document.write(' <param name="quality" value="best" />');
	document.write(' <param name="wmode" value="'+swfMode+'" />');
	document.write(' <embed src="'+swfLocation+variaveis+'" wmode="'+swfMode+'" quality="best" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="'+x+'" height="'+y+'"></embed>');
	document.write(' </object>');
}

function popUp(url,title,x,y,hasScroll) {
	window.open(url,title,'status=no,resizable=no,width='+x+',height='+y+',scrollbars='+hasScroll);
}

$(document).ready(function(){
	$("#button_busca").click(function(e){
		e.preventDefault();
		$("#frmbusca").submit();
	});
});