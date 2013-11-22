<?php
include('config/config.php');
?>
<!doctype html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<title>Nome do Candidato - CandiDados</title>
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
	<?php 
	if(isset($_GET['candidato'])){
		include("includes/candidato.php"); 
	}else{
		include("includes/localidade.php");
	}
	?>
	<footer>
		<?php include("includes/rodape.php");  ?>
	</footer>
</body>
</html>