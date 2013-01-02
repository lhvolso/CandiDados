<form method="get" class="busca">
	<label for="busca">Pesquise pelo nome do candidato, ano da eleição ou local:</label>
	<input type="text" name="busca" id="busca" value="<?php echo @$_GET['query']; ?>">
	<!--<input type="hidden" name="tabela" id="tabela">-->
	<!--<input type="hidden" name="id" id="id">-->
	<button type="submit">Buscar</button>
</form>