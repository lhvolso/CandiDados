<?php
$ano = $_GET['ano'];
$nomeCand = $_GET['candidato'];
$cidadeCand = $_GET['cidade'];
$busca_ue = mysql_query("SELECT codigo_tse FROM cidades WHERE titulo_amigavel = '".$cidadeCand."'") or die (mysql_error());
$codUE = mysql_result($busca_ue, 0, 'codigo_tse');
$sql = "SELECT * FROM candidatos WHERE nome_amigavel = '".$nomeCand."' AND ano_eleicao = ".$ano." AND sigla_ue = ".$codUE."";
$busca_cand = mysql_query($sql) or die (mysql_error());
$dados = mysql_fetch_array($busca_cand);
if($dados['desc_sit_tot_turno_2'] != ''){
	$situacao = $dados['desc_sit_tot_turno_2'];
	$turnoSQL = 'desc_sit_tot_turno_2';
	$numTurno = 2;
	$nomeTurno = 'Segundo Turno';
}else{
	$situacao = $dados['desc_sit_tot_turno_1'];
	$turnoSQL = 'desc_sit_tot_turno_1';
	$numTurno = 1;
	$nomeTurno = 'Primeiro Turno';
}	
?>
<div class="centro internas candidato">
	<article>
		<figure>
			<img src="http://divulgacand2012.tse.jus.br/divulgacand2012/mostrarFotoCandidato.action?sqCandidato=<?php echo $dados['sequencial_candidato']; ?>&amp;codigoMunicipio=<?php echo utf8_encode($dados['sigla_ue']); ?>" alt="Foto de urna do candidato <?php echo utf8_encode($dados['nome_urna_candidato']); ?>">
			<figcaption>Foto de urna do candidato <?php echo utf8_encode($dados['nome_urna_candidato']); ?></figcaption>
		</figure>
		<h1 class="tituloazul"><?php echo utf8_encode($dados['nome_urna_candidato']); ?></h1>
		<p class="margem">
			<strong><?php echo utf8_encode($dados['nome_candidato']); ?></strong>, 
			<?php echo utf8_encode($dados['descricao_nacionalidade']); ?>, 
			<?php echo utf8_encode($dados['descricao_estado_civil']); ?>, 
			nascido em <?php echo utf8_encode($dados['nome_municipio_nascimento']); ?>/<?php echo utf8_encode($dados['sigla_uf_nascimento']); ?> 
			em <?php echo utf8_encode($dados['data_nascimento']); ?>.
		</p>
		<p class="margem">Escolaridade: <strong><?php echo utf8_encode($dados['descricao_grau_instrucao']); ?></strong></p>
		<p>Profissão: <strong><?php echo utf8_encode($dados['descricao_ocupacao']); ?></strong></p>
		
		<h2 class="clear tituloazul">Eleições <?php echo $ano; ?></h2>
		<!-- <ul class="outrosanos">
			<li><a href="#">2010</a></li>
			<li><a href="#">2008</a></li>
		</ul> -->
		<?php
		$busca_validos = mysql_query("SELECT SUM(qtde_votos_nominais) AS validos FROM consulta_votos WHERE sigla_ue = ".$dados['sigla_ue']." AND numero_turno = ".$numTurno." AND ano_eleicao = ".$ano." AND codigo_cargo = ".$dados['codigo_cargo']."") or die (mysql_error());
		$numValidos = mysql_result($busca_validos, 0, 'validos');
		$sql_vot = "SELECT SUM(total_votos) AS soma, t2.nome_urna_candidato, t2.desc_sit_tot_turno_1, t2.desc_sit_tot_turno_2 FROM candidatos_votacao AS t1 INNER JOIN candidatos AS t2 ON t1.sequencial_candidato = t2.sequencial_candidato WHERE t1.sigla_ue = ".$dados['sigla_ue']." AND t1.numero_turno = ".$numTurno." AND t1.ano_eleicao = ".$ano." AND t1.codigo_cargo = ".$dados['codigo_cargo']." GROUP BY t1.sequencial_candidato ORDER BY soma DESC";
		$busca_vot = mysql_query($sql_vot) or die (mysql_error());
		echo '<h3>'.utf8_encode($dados['descricao_cargo']).', '.$nomeTurno.' / '.$ano.'</h3>';
		echo '<table>';
			echo '<caption>Resultados em porcentagem e número de votos dos candidatos concorrentes.</caption>';
			echo '<thead>';
				echo '<tr>';
					echo '<th class="nome">Candidato</th>';
					echo '<th class="porcentagem">Porcentagem</th>';
					echo '<th class="votos">Total de Votos</th>';
					echo '<th class="resultado">Resultado</th>';
				echo '</tr>';
			echo '</thead>';
			echo '<tbody>';
			while($vot = mysql_fetch_array($busca_vot)){
				echo '<tr>';
					echo '<td><a href="'.amigavel($vot['nome_urna_candidato']).'">'.utf8_encode($vot['nome_urna_candidato']).'</a></td>';
					echo '<td class="center">'.number_format(round(($vot['soma'] / $numValidos) * 100, 2), 2, ',', '').'%</td>';
					echo '<td class="center">'.number_format($vot['soma'], 0, '', '.').'</td>';
					echo '<td class="right">'.utf8_encode($vot['desc_sit_tot_turno_'.$numTurno.'']).'</td>';
				echo '</tr>';
			}
				echo '</tbody>';
		echo '</table>';

		if($numTurno == 2){

			// $busca_validos = mysql_query("SELECT SUM(qtde_votos_nominais) AS validos FROM consulta_votos WHERE sigla_ue = ".$dados['sigla_ue']." AND numero_turno = 1 AND ano_eleicao = ".$ano." AND codigo_cargo = ".$dados['codigo_cargo']."") or die (mysql_error());
			// $numValidos = mysql_result($busca_validos, 0, 'validos');
			$sql_vot = "SELECT SUM(total_votos) AS soma, t2.nome_urna_candidato, t2.desc_sit_tot_turno_1, t2.desc_sit_tot_turno_2 FROM candidatos_votacao AS t1 INNER JOIN candidatos AS t2 ON t1.sequencial_candidato = t2.sequencial_candidato WHERE t1.sigla_ue = ".$dados['sigla_ue']." AND t1.numero_turno = 1 AND t1.ano_eleicao = ".$ano." AND t1.codigo_cargo = ".$dados['codigo_cargo']." GROUP BY t1.sequencial_candidato ORDER BY soma DESC";
			$busca_vot = mysql_query($sql_vot) or die (mysql_error());
			
			echo '<h3>'.utf8_encode($dados['descricao_cargo']).', Primeiro Turno / '.$ano.'</h3>';
			echo '<table>';
				echo '<caption>Resultados em porcentagem e número de votos dos candidatos concorrentes.</caption>';
				echo '<thead>';
					echo '<tr>';
						echo '<th class="nome">Candidato</th>';
						echo '<th class="porcentagem">Porcentagem</th>';
						echo '<th class="votos">Total de Votos</th>';
						echo '<th class="resultado">Resultado</th>';
					echo '</tr>';
				echo '</thead>';
				echo '<tbody>';
				while($vot = mysql_fetch_array($busca_vot)){
					echo '<tr>';
						echo '<td><a href="'.amigavel($vot['nome_urna_candidato']).'">'.utf8_encode($vot['nome_urna_candidato']).'</a></td>';
						echo '<td class="center">'.number_format(round(($vot['soma'] / $numValidos) * 100, 2), 2, ',', '').'%</td>';
						echo '<td class="center">'.number_format($vot['soma'], 0, '', '.').'</td>';
						echo '<td class="right">'.utf8_encode($vot['desc_sit_tot_turno_1']).'</td>';
					echo '</tr>';
				}
					echo '</tbody>';
			echo '</table>';

		}
		?>
	</article>
	<aside>
		<h2>Dados de Campanha</h2>
		<!-- <ul class="outrosanos">
			<li>2012</li>
			<li><a href="#">2010</a></li>
			<li><a href="#">2008</a></li>
		</ul> -->
		<p class="margem">Cargo pretendido: <strong><?php echo utf8_encode($dados['descricao_cargo']); ?> (<?php echo utf8_encode($situacao); ?>)</strong></p>
		<p class="margem">Partido: <strong><?php echo utf8_encode($dados['sigla_partido']); ?></strong></p>
		<p>Valor dos bens declarados na ultima eleição:</p>
		<p class="margem"><strong>R$ <?php echo number_format($dados['valor_total_bens'], 2, ',', '.'); ?></strong></p>

		<p>Valor máximo de gastos na campanha:</p>
		<?php
		if($dados['despesa_max_campanha'] == '-1.00'){
			$maxCampanha = 'Não informado';
		}else{
			$maxCampanha = 'R$ '.number_format($dados['despesa_max_campanha'], 2, ',', '.');
		}
		?>
		<p class="margem"><strong><?php echo $maxCampanha; ?><strong></p>
		<!--
		<p>Total de gastos declarados:</p>
		<p class="margem"><strong>R$ 1.200.00,00</strong></p>

		<p>Total de doações:</p>
		<p class="margem"><strong>R$ 200.000,00</strong></p>
		-->
	</aside>
</div>