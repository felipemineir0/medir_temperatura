<?php
// Configurações de Paginação
$registrosPorPagina = 5;
$paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($paginaAtual - 1) * $registrosPorPagina;

// Obter o total de registros dos últimos 20 e calcular o número de páginas
$totalRegistros = $temperaturaModel->contarTotalUltimos20(); // Chame o método correto
$totalPaginas = ceil($totalRegistros / $registrosPorPagina);

// Obter registros da página atual dentro dos últimos 20
$temperaturas = $temperaturaModel->obterComPaginacao($offset, $registrosPorPagina);
?>
