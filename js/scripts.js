$('document').ready(function(){
	$("#busca").autocomplete({
		source: function( request, response ) {
			$.ajax({
				type: "post",
				url: "retorna-dados.php",
				dataType: "json",
				data: { busca: request.term },
				success: function(data) {
					if(data != null){
						response( $.map(data, function(item){
							return{	label: item.label, value: item.value, id: item.id}
						}));
					}
				}
			});
		},
		minLength: 3,
		select: function( event, ui ) {
			$('#tabela').val(ui.item.label);
			$('#id').val(ui.item.id);
			$('#busca').parent().submit();
		},
	})
	.data( "autocomplete" )._renderItem = function( ul, item ) {
		return $( "<li></li>" )
			.data( "item.autocomplete", item )
			.append( "<a>" + item.value + " <span>" + item.label + "</span></a>")
			.appendTo( ul );
	};
});