<?php
include('config/config.php');
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
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/layout.css">
	<link href="http://fonts.googleapis.com/css?family=Titillium+Web:400,200,700" rel="stylesheet" type="text/css">
</head>
<body>
<?php
//echo 'Pesquisa: '.$_GET['query'].'<br>';
//echo 'Ano: '.$_GET['ano'].'<br>';
//echo 'Estado: '.$_GET['estado'].'<br>';
//echo 'Cidade: '.$_GET['cidade'].'<br>';
//echo 'Candidato: '.$_GET['candidato'].'<br>';

$string = tiraAcento($_GET['query']);
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
	$sql .= "(SELECT nome_urna_candidato AS nome, id_candidato AS id, CONCAT('Candidato') AS tabela FROM candidatos WHERE ";
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
	$sql .= "(SELECT titulo_estado AS nome, id_estado AS id, CONCAT('Estado') AS tabela FROM estados WHERE ";
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
	$sql .= "(SELECT titulo_cidade AS nome, id_cidade AS id, CONCAT('Cidade') AS tabela FROM cidades WHERE ";
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
$sql .= ") x GROUP BY nome ORDER BY relevancia DESC, tabela DESC, nome LIMIT 0, 10";
$busca = mysql_query($sql) or die (mysql_error());
while($res = mysql_fetch_array($busca)){

	echo '<p>'.utf8_encode($res['nome']).'</p>';
	
}
mysql_free_result($busca);
mysql_close($connect);

function tiraAcento($var){
	$var = mb_strtolower($var, 'UTF-8');
	$var = preg_replace("/á|ã|à|â|ä/", "a", $var);	
	$var = preg_replace("/é|è|ê|ë/","e",$var);
	$var = preg_replace("/í|ì/","i",$var);		
	$var = preg_replace("/ó|ò|ô|õ|ö/","o",$var);	
	$var = preg_replace("/ú|ù|û|ü/","u",$var);
	$var = str_replace("ç","c",$var);
	return $var;
}

?>
</body>
</html>