<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<div class="card-panel teal lighten-5 z-depth-1" style="padding: 20px; border-radius: 10px;">
    <div class="row valign-wrapper">
        <div class="col s2">
            <i class="large material-icons" style="color: #ff7043;">thermostat</i>
        </div>
        <div class="col s10">
            <span class="black-text">
                <h5 class="center-align">Temperatura Atual</h5>
                <p id="temperature-display" class="flow-text center-align" style="font-size: 2rem; color: #00796b;">
                    Carregando...
                </p>
            </span>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Função para buscar a temperatura atual
        function fetchTemperature() {
            $.ajax({
                url: '/loja/model/getTemperature.php', // Buscar a temperatura na API
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.temperature) {
                        var temperature = parseFloat(response.temperature).toFixed(0);
                        $('#temperature-display').text(temperature + ' °C');
                        
                        // Salvar a temperatura no banco de dados
                        saveTemperature(temperature);
                    } else {
                        $('#temperature-display').text('Erro ao obter temperatura');
                    }
                },
                error: function() {
                    $('#temperature-display').text('Erro na comunicação com o servidor');
                }
            });
        }

        // Função para salvar a temperatura no banco de dados
        function saveTemperature(temperature) {
            $.ajax({
                url: '/loja/controller/TemperaturaController.php', // Salvar a temperatura no BD
                type: 'POST',
                data: {
                    temperatura: temperature,
                    acao: 'create'
                },
                success: function(response) {
                    console.log('Temperatura salva com sucesso!');
                },
                error: function() {
                    console.log('Erro ao salvar temperatura');
                }
            });
        }

        // Chama a função para buscar a temperatura ao carregar a página
        fetchTemperature();
    });
</script>