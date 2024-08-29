<?php
// Inclua o modelo de temperatura
require_once $_SERVER["DOCUMENT_ROOT"] . "/loja/model/TemperaturaModel.php";

// Verifique a ação
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['acao'] === 'create') {
    // Obtenha a temperatura do POST
    $temperatura = isset($_POST['temperatura']) ? floatval($_POST['temperatura']) : 0;

    // Arredonde a temperatura para o inteiro mais próximo
    $temperatura = round($temperatura);

    // Crie uma instância do modelo de temperatura e salve
    $temperaturaModel = new TemperaturaModel();
    $temperaturaModel->salvar($temperatura);

    echo "Temperatura salva com sucesso!";
}
?>