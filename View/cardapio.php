<?php session_start();
    require_once "../Controller/CardapioController.php";
    date_default_timezone_set('America/Sao_Paulo');

    $cardapio = (new CardapioController())->getCardapio();
    $current_time = date("H:m:s");
    $current_day = date("Y-m-d");
    $horario_padrao = (new CardapioController())->getTime();
    $idUser = $_SESSION['id'];
    $hasRefeicao = (new CardapioController())->hasRefeicao($idUser, $current_day);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/cardapio.css">
    <script type="module" src="js/index.js"></script>
    <title>Cardapio Semanal</title>
</head>
<body>
    <header class="session-1"> <a href='https://portal.ifba.edu.br/seabra' target='_blank'> <img class="img-logo" src='assets/1b1210fdf4454600bea220983da0cc63.png' alt='logo-ifba-seabra' draggable='false'> </a> </header>
    <?php include_once("navbar.php"); showNav("default"); ?>
    

    <div class="container">
        <h1 class="titulo">CARDÁPIO SEMANAL</h1>
        <img src="assets/cozinheira.png" alt="Imagem do Boneco" class="image2" draggable="false">
        <table class="print-content">
            <?php
                if ($cardapio[0]['dia'] != '') {
                    echo "
                        <thead>
                            <tr>
                                <th>Dia</th>
                                <th>Proteína</th>
                                <th>Acompanhamento</th>
                                <th>Sobremesa</th>
                            </tr>
                        </thead>
                        <tbody>";

                    foreach ($cardapio as $dia) {
                        if ($dia['principal'] != 'Sem refeição') {
                            $data = date("d/m", strtotime($dia['data'])); 
                            $newDia = ucfirst($dia['dia']) . "-feira";
                            echo "<tr>";
                            echo "<td>$newDia ($data)</td>";
                        } else {
                            echo "<tr>";
                            echo "<td>{$dia['dia']}</td>";
                        }
                        echo "<td>{$dia['principal']}</td>";
                        echo "<td>{$dia['acompanhamento']}</td>";
                        echo "<td>{$dia['sobremesa']}</td>";
                        echo "</tr>";
                    }

                    echo "</tbody>";
                    echo "</table>";
                }
            ?>
        </table>

        <template class='null-adm'>
            <h3 class='null'>O cardápio ainda está vazio. Adicione um agora</h3>
            <a href='cardapio-criar.php'><button class='button'>Adicionar cardápio</button></a>
        </template>

        <template class='null-user'>
            <h3 class='null'>O cardápio ainda está vazio. Aguarde por atualizações.</h3>
        </template>

        <template class='adm-template'>
            <div class='separador'>
                <div class='button-group'>
                    <button class='button-excluir' onclick='cardapio_popup()'>Excluir</button>
                    <a href='cardapio-alterar.php'><button class='button-editar'>Editar</button></a>
                    <button class='button-imprimir' onclick='imprimirCardapio();'>Imprimir Cardápio</button>
                </div>
            </div>
        </template>

        <template class='user-template-agendado'>
            <a href='agendados.php'><button class='button agendado'>Minha Reserva</button></a>
        </template>

        <template class='user-template-out-time'>
            <span class='horario-limite'>Horário limite atingido!</span>
        </template>

        <template class='user-template-in-time'>
            <a href='cardapio-reserva.php'><button class='button'>Quero almoçar!</button></a>
        </template>

        <div class="overlay" id="overlay"></div>
        <div class="popup" id="popup">
            <h2>Reserva Confirmada!</h2>
            <p>Sua reserva foi confirmada com sucesso.</p>
            <!-- Campo de Feedback -->
            <div class="feedback-container">
                <h3>Deixe seu feedback:</h3>
                <textarea id="feedback" name="feedback" rows="4" placeholder="Digite seu feedback aqui..."></textarea>
                <button id="btn-submit-feedback">Enviar Feedback</button>
            </div>
            <button class="close">Fechar</button>
        </div>

        <div class="info"></div>
    </div>
    <script>
        const diaDaSemana = (new Date()).getDay();
        const category = <?= json_encode($_SESSION['category']) ?>;
        const cardapio = <?= json_encode($cardapio) ?>;
        const current_time = <?= json_encode($current_time) ?>;
        const horario_padrao = <?= json_encode($horario_padrao) ?>;
        const hasRefeicao = <?= json_encode($hasRefeicao) ?>;

        if (category === "adm" && cardapio.length > 0 && cardapio[0]['dia'] !== '') {
            showTemplate(2);
        } else if (category === "adm" && (cardapio.length === 0 || cardapio[0]['dia'] === '')) {
            showTemplate(0);
        } else if (category !== "adm" && cardapio.length > 0 && cardapio[0]['dia'] !== '') {
            if (hasRefeicao !== null && hasRefeicao) {
                showTemplate(3);
            } else if (diaDaSemana === 0 || diaDaSemana === 6) {
                showTemplate(4);
            } else if (current_time >= horario_padrao) {
                showTemplate(4);
            } else if (current_time <= horario_padrao) {
                showTemplate(5);
            } 
        } else if (category !== "adm" && (cardapio.length === 0 || cardapio[0]['dia'] === '')) {
            showTemplate(1);
        }

        function showTemplate(template) {
            const templates = document.querySelectorAll('template');
            const div = document.querySelector('.info');
            if (templates[template]) {
                div.innerHTML = templates[template].innerHTML;
            } else {
                console.log("Template não encontrado!");
            }
        }
    </script>
    <?php require_once "footer.php"; ?>
</body>
</html>