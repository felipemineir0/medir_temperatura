<?php
// getTemperature.php

require_once $_SERVER["DOCUMENT_ROOT"] . "/loja/model/ReceberTemperaturaModel.php";

// Substitua 'YOUR_API_KEY' pela sua chave de API do OpenWeather
$apiKey = '39153c23f733ed828f8de385fd944427';
$city = 'Patos de Minas';

// Crie uma instância da classe ReceberTemperaturaModel
$ReceberTemperaturaModel = new ReceberTemperaturaModel($apiKey, $city);
$temperature = $ReceberTemperaturaModel->getTemperature();

// Retorna a temperatura em formato JSON
echo json_encode(['temperature' => $temperature]);