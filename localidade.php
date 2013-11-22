<?php
include('config/config.php');
?>
<!doctype html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<title>Nome da Localidade - CandiDados</title>
	<meta name="keywords" content="">
	<meta name="description" content="">
	<meta name="author" content="Luiz Henrique Volso">
	<meta name="robots" content="noindex">
	<link rel="stylesheet" href="<?php echo $path;?>/css/reset.css">
	<link rel="stylesheet" href="<?php echo $path;?>/css/layout.css">
	<link href="http://fonts.googleapis.com/css?family=Titillium+Web:400,200,700" rel="stylesheet" type="text/css">
	<script src="<?php echo $path;?>/js/jquery.js"></script>
	<script src="<?php echo $path;?>/js/scripts.js"></script>
</head>
<body>
	<header class="internas">
		<div class="centro">
			<a href="<?php echo $path; ?>" class="logo">CANDI<strong>DADOS</strong></a>
			<div id="publicidade">
				<a href="#"><img src="<?php echo $path;?>/imagens/banner-728x90.png" alt=""></a>
			</div>
			<?php include("includes/form-busca.php"); ?>
		</div>
	</header>
	<div class="centro internas">
		<article>
			<h1 class="tituloazul">Paraná</h1>
			<h2>Governador, Segundo Turno / 2010</h2>
			<table>
				<caption>Resultados em porcentagem e número de votos dos candidatos concorrentes.</caption>
				<thead>
					<tr>
						<th class="nome">Candidato</th>
						<th class="porcentagem">Porcentagem</th>
						<th class="votos">Total de Votos</th>
						<th class="resultado">Resultado</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><a href="candidato/beto-richa-45">Almir Fernandes de Oliveira</a></td>
						<td class="center">52,44%</td>
						<td class="center">3.039.774</td>
						<td class="right">Eleito</td>
					</tr>
					<tr>
						<td><a href="candidato/osmar-dias-23">Osmar Dias</a></td>
						<td class="center">52,44%</td>
						<td class="center">3.039.774</td>
						<td class="right">Não Eleito</td>
					</tr>
				</tbody>
			</table>
			
			<h2>Governador, Primeiro Turno / 2010</h2>
			<table>
				<caption>Resultados em porcentagem e número de votos dos candidatos concorrentes.</caption>
				<thead>
					<tr>
						<th class="nome">Candidato</th>
						<th class="porcentagem">Porcentagem</th>
						<th class="votos">Total de Votos</th>
						<th class="resultado">Resultado</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><a href="candidato/beto-richa-45">Beto Richa</a></td>
						<td class="center">52,44%</td>
						<td class="center">3.039.774</td>
						<td class="right">Eleito</td>
					</tr>
					<tr>
						<td><a href="candidato/osmar-dias-23">Osmar Dias</a></td>
						<td class="center">52,44%</td>
						<td class="center">3.039.774</td>
						<td class="right">Não Eleito</td>
					</tr>
					<tr>
						<td><a href="candidato/paulo-salamuni-13">Paulo Salamuni</a></td>
						<td class="center">1,41%</td>
						<td class="center">3.039.774</td>
						<td class="right">Não Eleito</td>
					</tr>
				</tbody>
			</table>
			<!-- <a href="#">Resultado completo dessa votação</a> -->
			
			<h2>Senador, 2010</h2>
			<table>
				<caption>Resultados em porcentagem e número de votos dos candidatos concorrentes.</caption>
				<thead>
					<tr>
						<th class="nome">Candidato</th>
						<th class="porcentagem">Porcentagem</th>
						<th class="votos">Total de Votos</th>
						<th class="resultado">Resultado</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><a href="candidato/beto-richa-45">Beto Richa</a></td>
						<td class="center">52,44%</td>
						<td class="center">3.039.774</td>
						<td class="right">Eleito</td>
					</tr>
					<tr>
						<td><a href="candidato/osmar-dias-23">Osmar Dias</a></td>
						<td class="center">52,44%</td>
						<td class="center">3.039.774</td>
						<td class="right">Não Eleito</td>
					</tr>
					<tr>
						<td><a href="candidato/paulo-salamuni-13">Paulo Salamuni</a></td>
						<td class="center">1,41%</td>
						<td class="center">3.039.774</td>
						<td class="right">Não Eleito</td>
					</tr>
				</tbody>
			</table>
			<!-- <a href="#">Resultado completo dessa votação</a> -->
			
			<a href="#" class="maisdetalhes fleft">Resultados de Deputados Federais</a>
			<a href="#" class="maisdetalhes fright">Resultados de Deputados Estaduais</a>
		</article>
		<aside>
			<h2 class="tituloazul">Dados do Eleitorado</h2>
			<p>O Paraná possui 700 000 eleitores, 50% são mulheres e dentre eles 94,2% compareceram às urnas na eleição de 2012.</p>

			<p>O estado totalizou 680 754 votos válidos (92%), 32 000 votos brancos e 12 000 nulos</p>
			
			<!-- <a href="#">Dados completos do eleitorado</a> -->
			
			<h2 class="tituloazul margem">Principais Cidades</h2>
			<ul>
				<li><a href="#">Curitiba</a></li>
				<li><a href="#">Londrina</a></li>
				<li><a href="#">Maringá</a></li>
				<li><a href="#">Foz do Iguaçu</a></li>
				<li><a href="#">Campo Mourão</a></li>
			</ul>
		</aside>
	</div>
	<footer>
		<?php include("includes/rodape.php");  ?>
	</footer>
</body>
</html>