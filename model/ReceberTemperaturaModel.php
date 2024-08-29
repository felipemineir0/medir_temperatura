<?php

class ReceberTemperaturaModel
{
    private $apiKey;
    private $city;

    public function __construct($apiKey, $city)
    {
        $this->apiKey = $apiKey;
        $this->city = $city;
    }

    public function getTemperature()
    {
        $apiUrl = "http://api.openweathermap.org/data/2.5/weather?q=" . urlencode($this->city) . "&appid=" . $this->apiKey . "&units=metric";

        // Inicializa uma sessão cURL
        $ch = curl_init();

        // Configura a URL e outras opções de cURL
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // Executa a requisição e obtém a resposta
        $response = curl_exec($ch);

        // Verifica se houve erro na execução do cURL
        if (curl_errno($ch)) {
            echo 'Erro cURL: ' . curl_error($ch);
            return 'Dados de temperatura não disponíveis';
        }

        // Fecha a sessão cURL
        curl_close($ch);

        // Decodifica a resposta JSON
        $data = json_decode($response, true);

        // Verifica se a resposta contém dados de temperatura
        if (isset($data['main']['temp'])) {
            return $data['main']['temp'];
        } else {
            return 'Dados de temperatura não disponíveis';
        }
    }
}