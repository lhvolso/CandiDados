<?php
include('config/config.php');
header("Content-Type: text/html; charset=UTF-8");
$string = tiraAcento($_POST['busca']);

//Verifica a existência do ano na busca
//if(preg_match_all('/20[0-9][02468]/', $string, $saida)){
//	$ano = $saida[0][0];
//}else{
//	$ano = '';
//}

//Retirar o ano encontado da string original
//$string = str_replace($ano, '', $string);

//Dividir os termos para a busca por relevância
$termos = preg_split("/[ .,;']/", $string);
//echo implode(' ', $termos);
foreach($termos as $termo){
	//echo $termo.', ';
}

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
$i = 0;
while($res = mysql_fetch_array($busca)){

	$retorno[$i] = Array(

		'label' => $res['tabela'],
		'value' => utf8_encode($res['nome']),
		'id' => $res['id']

	);
	$i++;
}
echo json_encode($retorno);
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
// SELECT nome, tabela, 
// SUM(CASE WHEN nome LIKE 'sao joao' THEN 1 ELSE 0 END) + 
// SUM(CASE WHEN nome LIKE '%sao joao%' THEN 1 ELSE 0 END) + 
// SUM(CASE WHEN nome LIKE '%sao%' THEN 1 ELSE 0 END) + 
// SUM(CASE WHEN nome LIKE '%joao%' THEN 1 ELSE 0 END) AS relevancia  
// FROM (
// 	(SELECT nome_urna_candidato AS nome, CONCAT('candidato') AS tabela FROM candidatos WHERE 
// 		(nome_urna_candidato LIKE '%sao%') OR 
// 		(nome_urna_candidato LIKE '%joao%') GROUP BY nome_urna_candidato)
// 	UNION
// 	(SELECT titulo_estado AS nome, CONCAT('estado') AS tabela FROM estados WHERE 
// 		(titulo_estado LIKE '%sao%') OR 
// 		(titulo_estado LIKE '%joao%') GROUP BY titulo_estado)
// 	UNION	
// 	(SELECT titulo_cidade AS nome, CONCAT('cidade') AS tabela FROM cidades WHERE 
// 		(titulo_cidade LIKE '%sao%') OR 
// 		(titulo_cidade LIKE '%joao%') GROUP BY titulo_cidade)
// 	) x
// GROUP BY nome ORDER BY relevancia DESC, nome
?>