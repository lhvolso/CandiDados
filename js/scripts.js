function validar() {
	var conteudo = $('#busca').val();
	$('#busca').val(retiraAcento(conteudo));
	if(conteudo == ''){
		return false;
	} else {
		return true;
	}
}

function retiraAcento(texto){
    txt = texto.toLowerCase();
    txt = txt.replace(/[á|ã|â|à]/gi, "a");
    txt = txt.replace(/[é|ê|è]/gi, "e");
    txt = txt.replace(/[í|ì|î]/gi, "i");
    txt = txt.replace(/[õ|ò|ó|ô]/gi, "o");
    txt = txt.replace(/[ú|ù|û]/gi, "u");
    txt = txt.replace(/[ç]/gi, "c");
    txt = txt.replace(/[ñ]/gi, "n");
    txt = txt.replace(/[á|ã|â]/gi, "a");
    return txt;
}

// $('document').ready(function(){
// 	$("#busca").autocomplete({
// 		source: function( request, response ) {
// 			$.ajax({
// 				type: "post",
// 				url: "retorna-dados.php",
// 				dataType: "json",
// 				data: { busca: request.term },
// 				success: function(data) {
// 					if(data != null){
// 						response( $.map(data, function(item){
// 							return{	label: item.label, value: item.value, id: item.id}
// 						}));
// 					}
// 				}
// 			});
// 		},
// 		minLength: 3,
// 		select: function( event, ui ) {
// 			$('#tabela').val(ui.item.label);
// 			$('#id').val(ui.item.id);
// 			$('#busca').parent().submit();
// 		},
// 	})
// 	.data( "autocomplete" )._renderItem = function( ul, item ) {
// 		return $( "<li></li>" )
// 			.data( "item.autocomplete", item )
// 			.append( "<a>" + item.value + " <span>" + item.label + "</span></a>")
// 			.appendTo( ul );
// 	};
// });