<!-- Exibir coisas relacionadas a mesa que está -->
<?php
    include_once "conexao.php";
    date_default_timezone_set('America/Sao_Paulo');

    session_start();

    $codigo = $_SESSION['codUsuario'];
    $codJogo = $_GET['codJogo'];

    $select = $con->prepare("SELECT p.classe FROM persona p INNER JOIN jogo j, usuario u WHERE j.codJogo = $codJogo AND j.player1 = u.codUsuario AND p.codPersona = u.personagem");
    $select->execute();

    while ($result = $select->fetch()) {
        $player1=$result['classe'];
    }

    if (empty($player1)) {
        $player1 = "noplayer";
    }

    $select = $con->prepare("SELECT p.classe FROM persona p INNER JOIN jogo j, usuario u WHERE j.codJogo = $codJogo AND j.player2 = u.codUsuario AND p.codPersona = u.personagem");
    $select->execute();

    while ($result = $select->fetch()) {
        $player2=$result['classe'];
    }

    if (empty($player2)) {
        $player2 = "noplayer";
    }

    $select = $con->prepare("SELECT p.classe FROM persona p INNER JOIN jogo j, usuario u WHERE j.codJogo = $codJogo AND j.player3 = u.codUsuario AND p.codPersona = u.personagem");
    $select->execute();

    while ($result = $select->fetch()) {
        $player3=$result['classe'];
    }

    if (empty($player3)) {
        $player3 = "noplayer";
    }

    $select = $con->prepare("SELECT p.classe FROM persona p INNER JOIN jogo j WHERE j.codJogo = $codJogo AND j.oponente = p.codPersona");
    $select->execute();

    while ($result = $select->fetch()) {
        $oponente=$result['classe'];
    }

    if (empty($oponente)) {
        $oponente = "noplayer";
    }

    $select = $con->prepare("SELECT cenario FROM jogo j WHERE $codJogo = j.codJogo");
    $select->execute();

    while ($result = $select->fetch()) {
        $cenario=$result['cenario'];
    }

    $select = $con->prepare("SELECT numDado FROM jogo j WHERE $codJogo = j.codJogo");
    $select->execute();

    while ($result = $select->fetch()) {
        $numDado=$result['numDado'];
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela do Jogo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/pages/telaJogadores.css">

    <?php
    echo '<style>';
        echo 'body{';
            echo "background-image: url('assets/images/".$cenario.".jpg');";
        echo '}';
    echo '</style>';
    ?>

</head>
<body>

    <div class="container text-center">
        <div class="row align-items-start">
            <div class="col">
                <!-- <img src="assets/images/dice2.png" alt="dado"> -->
                <div class="dice">
                <?php echo '<span class="dice-result">'.$numDado.'</span>'?>
                </div>
                <div>
                    <?php echo '<img src="assets/images/'.$player1.'.png" alt="'.$player1.'" width="200px">'?>
                    <?php echo '<img src="assets/images/'.$player2.'.png" alt="'.$player2.'" width="200px">'?>
                    <?php echo '<img src="assets/images/'.$player3.'.png" alt="'.$player3.'" width="200px">'?>
                    <?php echo '<img src="assets/images/'.$oponente.'.png" alt="'.$oponente.'" width="200px">'?>
                </div>
            </div>
            <div class="col" id="borda">
                <?php
                $select = $con->prepare("SELECT p.forca, p.inteligencia, p.destreza, p.vida FROM persona p INNER JOIN usuario u WHERE u.codUsuario = $codigo AND p.codPersona = u.personagem");
                $select->execute();
                echo '<h2>Status</h2>';
                while ($result = $select->fetch()) {
                    $forca=$result['forca'];
                    $inteligencia=$result['inteligencia'];
                    $destreza=$result['destreza'];
                    $vida=$result['vida'];

                    echo '<ul type="none">';
                        echo "<li>Força ".$forca."</li>";
                        echo "<li>Inteligência ".$inteligencia."</li>";
                        echo "<li>Destreza ".$destreza."</li>";
                        echo "<li>Vitalidade ".$vida."</li>";
                    echo "</ul>";    
                        
                }

                $select = $con->prepare("SELECT nomeHabilidade FROM habilidade h INNER JOIN persona p, usuario u WHERE u.codUsuario = $codigo AND p.codPersona = u.personagem AND h.codHabilidade =p.skill");
                $select->execute();
                echo '<h2>Habilidades</h2>';
                while ($result = $select->fetch()) {
                    $nomeHab=$result['nomeHabilidade'];

                    if (empty($nomeHab)) {
                        $nomeHab = "Sem habilidade";
                    }

                    echo '<ul type="none">';
                        echo "<li>".$nomeHab."</li>";
                    echo "</ul>";    
                        
                }

                $select = $con->prepare("SELECT nomeItem FROM item i INNER JOIN persona p, usuario u WHERE u.codUsuario = $codigo AND p.codPersona = u.personagem AND i.codItem =p.item");
                $select->execute();
                echo '<h2>Acessórios</h2>';
                while ($result = $select->fetch()) {
                    $nomeItem=$result['nomeItem'];

                    if (empty($nomeItem)) {
                        $nomeItem = "Sem habilidade";
                    }
                    
                    echo '<ul type="none">';
                        echo "<li>".$nomeItem."</li>";
                    echo "</ul>";    
                        
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.onload = function() {
            const storedDiceResult = localStorage.getItem('diceResult');
            const storedDiceShape = localStorage.getItem('diceShape');

            // Atualiza o resultado do dado se houver
            if (storedDiceResult) {
                document.querySelector('.dice-result').textContent = storedDiceResult;
            }

            // Atualiza o formato do dado se houver
            if (storedDiceShape) {
                const diceElement = document.querySelector('.dice');
                if (parseInt(storedDiceShape) === 6) {
                    diceElement.classList.add('square');
                    diceElement.classList.remove('hexagon');
                } else {
                    diceElement.classList.add('hexagon');
                    diceElement.classList.remove('square');
                }
            }
        }

        // Listener para mudanças no localStorage
        window.addEventListener('storage', function(event) {
            const diceElement = document.querySelector('.dice');

            if (event.key === 'diceResult') {
                document.querySelector('.dice-result').textContent = event.newValue;
            }

            if (event.key === 'diceShape') {
                if (parseInt(event.newValue) === 6) {
                    diceElement.classList.add('square');
                    diceElement.classList.remove('hexagon');
                } else {
                    diceElement.classList.add('hexagon');
                    diceElement.classList.remove('square');
                }
            }
        });
    </script>
    
</body>
</html>

