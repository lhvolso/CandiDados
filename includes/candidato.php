<?php
$ano = $_GET['ano'];
$nomeCand = str_replace('-', ' ', $_GET['candidato']);
$sql = "SELECT t1.*, t2.valor_total_bens FROM candidatos AS t1 INNER JOIN candidatos_bens_resumo AS t2 ON t1.sequencial_candidato = t2.sequencial_candidato WHERE t1.nome_urna_candidato = '".$nomeCand."' AND t1.ano_eleicao = ".$ano."";
$busca_cand = mysql_query($sql) or die (mysql_error());
$dados = mysql_fetch_array($busca_cand);
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
		$sql_vot = "SELECT SUM(total_votos) FROM candidatos_votacao WHERE sequencial_candidato = ".$dados['sequencial_candidato']." AND numero_turno = 1 AND ano_eleicao = ".$ano."";

		//$sql_vot = "SELECT SUM(total_votos) AS total, t2.eleito_turno_1 FROM candidatos_votacao AS t1 INNER JOIN candidatos AS t2 ON t1.id_candidato = t2.id_candidato WHERE t1.numero_turno = 1 AND t1.sigla_ue = 78255 AND t1.numero_turno = 1 AND t1.codigo_c argo = 13 AND t2.eleito_turno_1 = 1 GROUP BY t1.sequencial_candidato ORDER BY total DESC";

		$busca_vot = mysql_query($sql_vot) or die (mysql_error());
		if(mysql_num_rows($busca_vot) == 1){

			echo '<h3>'.utf8_encode($dados['descricao_cargo']).', Primeiro Turno / '.$ano.'</h3>';

		}
		?>
		

		<h3>Governador, Segundo Turno / 2010</h3>
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
	</article>
	<aside>
		<h2>Dados de Campanha</h2>
		<ul class="outrosanos">
			<li>2012</li>
			<li><a href="#">2010</a></li>
			<li><a href="#">2008</a></li>
		</ul>
		<?php
		if($dados['desc_sit_tot_turno_2'] != ''){
			$situacao = $dados['desc_sit_tot_turno_2'];
		}else{
			$situacao = $dados['desc_sit_tot_turno_1'];
		}
		?>
		<p class="margem">Cargo pretendido: <strong><?php echo utf8_encode($dados['codigo_cargo']); ?> (<?php echo utf8_encode($situacao); ?>)</strong></p>
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