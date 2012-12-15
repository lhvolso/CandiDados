<!doctype html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<title>CandiDados - Informações sobre as Eleições Brasileiras</title>
	<meta name="keywords" content="">
	<meta name="description" content="">
	<meta name="author" content="Luiz Henrique Volso">
	<meta name="robots" content="noindex">
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/layout.css">
	<link rel="stylesheet" href="css/smoothness/jquery-ui-1.9.2.custom.css">
	<link href="http://fonts.googleapis.com/css?family=Titillium+Web:400,200,700" rel="stylesheet" type="text/css">
	<script src="js/jquery.js"></script>
	<script src="js/jquery-ui-full.js"></script>
	<script>
	$('document').ready(function(){

		$( "#busca" ).autocomplete({
			source: function( request, response ) {
				$.ajax({
					type: "post",
					url: "retorna-dados.php",
					dataType: "json",
					data: { busca: request.term },
					beforeSend: function(){
						
					},
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
	</script>
</head>
<body>
	<header class="inicial">
		<div class="centro">
			<h1 class="logo">CANDI<strong>DADOS</strong></h1>
			<p class="infobusca">Pesquise pelo nome do candidato, ano da eleição, local ou cargo:</p>
			<form method="get" class="busca">
				<input type="text" name="busca" id="busca" placeholder="ex.: Nome do candidato Paraná 2010">
				<input type="hidden" name="tabela" id="tabela">
				<input type="hidden" name="id" id="id">
				<button type="submit">Buscar</button>
			</form>
		</div>
	</header>
	<div class="centro inicio">
		<section class="fleft">
			<h2 class="tituloazul">Sobre o CandiDados</h2>
			<p>Layout com conceito minimalista com foco no conteúdo, em uma analogia a <strong>dados abertos</strong>, a fonte tipográfica é de <strong>uso livre</strong>, assim como a imagem do background e os ícones, os elementos abrem e não fecham (com exceção do imput e botões, e do software que utilizei).</p>
		</section>
		<section class="fright">
			<h2 class="tituloazul">Sobre Dados Abertos</h2>
			<p>As cores irão operar segundo um esquema de conteúdo estático ou interagível, que demanda de ação do usuário, títulos de textos utilizarão variações da cor azul seguindo uma hierarquia do mais forte para o mais claro, links, botões, inputs terão variações do laranja.</p>
		</section>
	</div>
	<footer>
		<div class="centro">
			<nav>
				<ul>
					<li><a href="#">o projeto</a></li>
					<li><a href="#">os desenvolvedores</a></li>
					<li><a href="#">glossário</a></li>
					<li><a href="#">ajuda</a></li>
				</ul>
			</nav>
		</div>
	</footer>
</body>
</html>