<?php
	ob_start();
?>
	<div id="formulario">
		<?php include "formulario.php"; ?>
	</div>

	<div id="tabela">
		<?php include "tabela.php" ?>
	</div>

<?php
 	$conteudo = ob_get_contents();
	$titulo = "Medidor de Temperatura";
 	ob_end_clean ();

	include '../layout.php';
?>