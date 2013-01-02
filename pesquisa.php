<?php
include('config/config.php');
if(isset($_GET['pg'])){
	$numPagina = str_replace('pagina-', '', $_GET['pg']);
} else {
	$numPagina = 1;
}
$string = $_GET['query'];
//Verifica a existência do ano na busca
if(preg_match_all('/20[0-9][0-9]/', $string, $saida)){
	$anoTemp = $saida[0][0];
	if(in_array($anoTemp, $anosEleicao)){
		$anoEscolhido = $anoTemp;
		$ano = $anoEscolhido;
	}else{
		$anoEscolhido = '';
		$ano = $anosEleicao[0];
	}
}else{
	$ano = $anosEleicao[0];
	$anoEscolhido = '';
}
//Retirar o ano encontado da string original
$string = str_replace($anoTemp, '', $string);
$string = tiraAcento(trim($string));
$termos = preg_split("/[ .,;']/", $string);
$i = 1;
$sql = "SELECT nome, id, tabela, ";
$sql .= "SUM(CASE WHEN nome LIKE '".trim(implode(' ', $termos))."' THEN 1 ELSE 0 END) + ";
$sql .= "SUM(CASE WHEN nome LIKE '%".trim(implode(' ', $termos))."%' THEN 1 ELSE 0 END) + ";
foreach($termos as $termo){
	$sql .= "SUM(CASE WHEN nome LIKE '%".$termo."%' THEN 1 ELSE 0 END)";
	if($i < count($termos)){
		$sql .= " + ";
	}else{
		$sql .= " AS relevancia ";
		$i = 0;
	}
	$i++;
}
$sql .= "FROM (";
	$sql .= "(SELECT nome_urna_candidato AS nome, CONCAT('candidato-',id_candidato) AS grupo, id_candidato AS id, CONCAT('Candidato') AS tabela FROM candidatos WHERE ";
	foreach($termos as $termo){
		$sql .= "(nome_urna_candidato LIKE '%".$termo."%')";
		if($i < count($termos)){
			$sql .= " OR ";
		}else{
			$sql .= " GROUP BY nome_urna_candidato)";
			$i = 0;
		}
		$i++;
	}
	$sql .= " UNION ";
	$sql .= "(SELECT titulo_estado AS nome, CONCAT('estado-',id_estado) AS grupo, id_estado AS id, CONCAT('Estado') AS tabela FROM estados WHERE ";
	foreach($termos as $termo){
		$sql .= "(titulo_estado LIKE '%".$termo."%')";
		if($i < count($termos)){
			$sql .= " OR ";
		}else{
			$sql .= " GROUP BY titulo_estado)";
			$i = 0;
		}
		$i++;
	}
	$sql .= " UNION ";
	$sql .= "(SELECT CONCAT(titulo_estado, '/', titulo_cidade) AS nome, CONCAT('cidade-',id_cidade) AS grupo, id_cidade AS id, CONCAT('Cidade') AS tabela FROM cidades AS t1 INNER JOIN estados AS t2 ON t2.id_estado = t1.id_estado  WHERE ";
	foreach($termos as $termo){
		$sql .= "(titulo_cidade LIKE '%".$termo."%')";
		if($i < count($termos)){
			$sql .= " OR ";
		}else{
			$sql .= " GROUP BY titulo_cidade)";
			$i = 0;
		}
		$i++;
	}
$sql .= ") x GROUP BY grupo ORDER BY relevancia DESC, tabela DESC, nome LIMIT 0, 200";
$busca = mysql_query($sql) or die (mysql_error());

$totalResultados = mysql_num_rows($busca);
$numMaxResultados = 10;
?>
<!doctype html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<title>Resultados da Pesquisa - CandiDados</title>
	<meta name="keywords" content="">
	<meta name="description" content="">
	<meta name="author" content="Luiz Henrique Volso">
	<meta name="robots" content="noindex">
	<link rel="stylesheet" href="<?php echo $path;?>/css/reset.css">
	<link rel="stylesheet" href="<?php echo $path;?>/css/layout.css">
	<link href="http://fonts.googleapis.com/css?family=Titillium+Web:400,200,700" rel="stylesheet" type="text/css">
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
			<h1 class="tituloazul">
				Resultados da pesquisa por: 
				<strong>
					<?php 
					$palavras = explode(' ', $string);
					if(count($palavras) > 1){
						foreach($palavras as $pal){
							echo '<a href="'.$path.'/pesquisa/'.$pal.'">'.$pal.'</a> ';
						}
					} else {
						echo $string;
					}
					?>
				</strong>
				<?php
				if($anoEscolhido != ''){
					echo '<small>nas eleiçoes de: </small><strong>'.$anoEscolhido.'</strong>';
				}
				?>
			</h1>
			<?php
			$i = 1;
			if(mysql_num_rows($busca) > 0){
				echo '<ul class="resultados">';
				while($res = mysql_fetch_assoc($busca)){
					if($res['tabela'] == 'Candidato'){
						echo '<li><h2><a href="'.$path.'/eleicoes-'.$ano.'/candidatos/'.amigavel($res['nome']).'">'.utf8_encode($res['nome']).' <small>'.$res['tabela'].'</small></a></h2></li>';
					} else if($res['tabela'] == 'Estado'){
						echo '<li><h2><a href="'.$path.'/eleicoes-'.$ano.'/'.amigavel($res['nome']).'">'.utf8_encode($res['nome']).' <small>'.$res['tabela'].'</small></a></h2></li>';
					} else if($res['tabela'] == 'Cidade'){
						$nomeCidade = explode('/', $res['nome']);
						echo '<li><h2><a href="'.$path.'/eleicoes-'.$ano.'/'.amigavel($res['nome']).'">'.utf8_encode($nomeCidade[1]).' <small>'.$res['tabela'].'</small></a></h2></li>';
					}	
					if($i == $numMaxResultados){
						break;
					} else {
						$i++;
					}
				}
				echo '</ul>';
			}
			mysql_free_result($busca);
			mysql_close($connect);
			if($numPagina > 1){
				echo '<a class="paginacao fleft" href="'.$path.'/pesquisa/'.str_replace(' ', '+', $_GET['query']).'/pagina-'.($numPagina-1).'">Página Anterior</a>';
			}
			if($totalResultados > ($numPagina * $numMaxResultados)){
				echo '<a class="paginacao fright" href="'.$path.'/pesquisa/'.str_replace(' ', '+', $_GET['query']).'/pagina-'.($numPagina+1).'">Próxima Página</a>';
			}
			?>
		</article>
	</div>
	<footer>
		<?php include("includes/rodape.php"); ?>
	</footer>
</body>
</html>