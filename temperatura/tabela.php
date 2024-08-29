<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/loja/model/TemperaturaModel.php";

$temperaturaModel = new TemperaturaModel();
require_once $_SERVER["DOCUMENT_ROOT"] . "/loja/controller/pagination.php";

// Obter os dados ordenados do último para o primeiro
$temperaturas = $temperaturaModel->obterComPaginacao($offset, $registrosPorPagina, 'id DESC'); // Ajuste para ordenar por ID DESC

// Preparar os dados para o gráfico
$labels = [];
$temperaturaData = [];
$eficienciaData = [];

foreach ($temperaturas as $t) {
    // Adicionar os dados ao array
    $labels[] = date('d/m H:i', strtotime($t["horario_registro"]));
    $temperaturaData[] = $t["temperatura"];

    // Calcular a eficiência
    $eficiencia = ($t["temperatura"] >= 28) ? 100 : (($t["temperatura"] < 24) ? 75 : round(75 + (25 * ($t["temperatura"] - 24)) / 4));
    $eficienciaData[] = $eficiencia;
}
?>

<div class="row">
    <!-- Tabela de Temperaturas -->
    <div class="col s12 m6">
        <div class="card-panel">
            <h4 class="center-align">Histórico de Temperaturas</h4>
            <table class="responsive-table highlight">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Temperatura</th>
                        <th>Data e Hora</th>
                        <th>Eficiência</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($temperaturas as $t):
                        // Calcular a eficiência com base na temperatura
                        $eficiencia = ($t["temperatura"] >= 28) ? 100 : (($t["temperatura"] < 24) ? 75 : round(75 + (25 * ($t["temperatura"] - 24)) / 4));
                        $corEficiencia = ($eficiencia == 100) ? 'green-text' : 'red-text';
                    ?>
                        <tr>
                            <td><?= $t["id"] ?></td>
                            <td><?= $t["temperatura"] ?> °C</td>
                            <td><?= date('d/m/Y H:i:s', strtotime($t["horario_registro"])) ?></td>
                            <td class="<?= $corEficiencia ?>"><?= $eficiencia ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Links de Navegação -->
            <ul class="pagination center-align">
                <li class="<?= ($paginaAtual <= 1) ? 'disabled' : 'waves-effect' ?>">
                    <a href="?pagina=<?= $paginaAtual - 1 ?>"><i class="material-icons">chevron_left</i></a>
                </li>
                <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                    <li class="<?= ($paginaAtual == $i) ? 'active blue' : 'waves-effect' ?>">
                        <a href="?pagina=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                <li class="<?= ($paginaAtual >= $totalPaginas) ? 'disabled' : 'waves-effect' ?>">
                    <a href="?pagina=<?= $paginaAtual + 1 ?>"><i class="material-icons">chevron_right</i></a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Gráfico de Temperatura e Eficiência -->
    <div class="col s12 m6">
        <canvas id="temperatureChart"></canvas>
    </div>
</div>

<!-- Adicione o script do Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Dados para o gráfico
        const labels = <?= json_encode(array_reverse($labels)) ?>; // Inverte os dados para mostrar o último primeiro
        const temperaturaData = <?= json_encode(array_reverse($temperaturaData)) ?>;
        const eficienciaData = <?= json_encode(array_reverse($eficienciaData)) ?>;

        // Configuração do gráfico
        const ctx = document.getElementById('temperatureChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                        label: 'Temperatura (°C)',
                        data: temperaturaData,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        fill: false,
                        tension: 0.1
                    },
                    {
                        label: 'Eficiência (%)',
                        data: eficienciaData,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        fill: false,
                        tension: 0.1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Data e Hora'
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Valores'
                        }
                    }
                }
            }
        });
    });
</script>