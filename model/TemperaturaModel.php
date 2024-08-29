<?php

class TemperaturaModel
{
    private $conexao;

    public function __construct()
    {
        // Conectando ao banco de dados
        $this->conexao = new mysqli("localhost", "root", "", "loja");

        if ($this->conexao->connect_error) {
            die("Falha na conexão: " . $this->conexao->connect_error);
        }
    }

    // Função para salvar a temperatura no banco de dados
    public function salvar($temperatura)
    {
        $sql = "INSERT INTO historico_temperatura (temperatura, horario_registro) VALUES (?, NOW())";
        $stmt = $this->conexao->prepare($sql);

        if ($stmt === false) {
            die("Erro na preparação: " . $this->conexao->error);
        }

        $stmt->bind_param("d", $temperatura);

        if ($stmt->execute()) {
            echo "Temperatura registrada com sucesso!";
        } else {
            echo "Erro ao salvar temperatura: " . $stmt->error;
        }

        $stmt->close();
    }

    // Função para obter todas as temperaturas (sem paginação)
    public function todas()
    {
        $sql = "SELECT * FROM historico_temperatura ORDER BY horario_registro DESC";
        $result = $this->conexao->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    // Função para contar o total de registros dos últimos 20 registros de temperatura
    public function contarTotalUltimos20()
    {
        $sql = "SELECT COUNT(*) as total FROM (SELECT * FROM historico_temperatura ORDER BY horario_registro DESC LIMIT 20) AS temp";
        $result = $this->conexao->query($sql);

        if ($result) {
            $row = $result->fetch_assoc();
            return $row['total'];
        } else {
            return 0;
        }
    }

    // Função para obter registros com paginação dentro dos últimos 20 registros
    public function obterComPaginacao($offset, $registrosPorPagina)
    {
        $sql = "SELECT * FROM (SELECT * FROM historico_temperatura ORDER BY horario_registro DESC LIMIT 20) AS temp ORDER BY horario_registro DESC LIMIT ?, ?";
        $stmt = $this->conexao->prepare($sql);

        if ($stmt === false) {
            die("Erro na preparação: " . $this->conexao->error);
        }

        // Vincula os parâmetros para offset e limite
        $stmt->bind_param("ii", $offset, $registrosPorPagina);

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }

        $stmt->close();
    }

    // Fechar a conexão quando a classe for destruída
    public function __destruct()
    {
        $this->conexao->close();
    }
}
?>
