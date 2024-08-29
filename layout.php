<?php
// Verifica se a sessão já está ativa antes de iniciar uma nova sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0" />
    <title><?php echo $titulo; ?></title>

    <link rel="shortcut icon" type="image/jpg" href="../thermostat.png" />

    <!-- CSS -->
    <link href="/loja/css/fonts.css" rel="stylesheet">
    <link href="/loja/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection" />
    <link href="/loja/css/style.css" type="text/css" rel="stylesheet" media="screen,projection" />

    <!-- Scripts -->
    <script src="/loja/js/jquery-3.2.1.min.js"></script>
    <script src="/loja/js/materialize.js"></script>
    <script src="/loja/js/init.js"></script>
</head>

<body>
    <div class="site-wrapper">
        <nav class="light-blue lighten-1" role="navigation">
            <div class="nav-wrapper container">
                <a id="logo-container" href="#" class="brand-logo">Medidor de Temperatura</a>
                <ul id="nav-mobile" class="side-nav">
                    <li><a href="/loja/index.php">Home</a></li>
                </ul>
                <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
            </div>
        </nav>

        <div class="section no-pad-bot site-content" id="index-banner">
            <div class="container">
                <?php echo $conteudo; ?>
            </div>
        </div>
    </div>

    <footer class="page-footer orange">
        <div class="container">
            <div class="row">
                <div class="col l6 s12">
                    <h5 class="white-text">
                        <a id="logo-container" href="/loja/index.php" class="brand-logo">Medidor de Temperatura</a>
                    </h5>
                    <p class="grey-text text-lighten-4"></p>
                </div>
                <div align="center" class="col l3 s12"></div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container"></div>
        </div>
    </footer>

    <script>
        // Função para recarregar a página
        function refreshPage() {
            window.location.reload();
        }

        // Atualiza a página a cada 30 segundos (30000 milissegundos)
        setInterval(refreshPage, 30000);
    </script>
</body>

</html>