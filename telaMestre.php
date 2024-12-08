<?php
    include_once "conexao.php";
    date_default_timezone_set('America/Sao_Paulo');

    $codJogo = $_GET['codJogo'];

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
    <title>Tela do Mestre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="css/common.css" rel="stylesheet">
    <link href="assets/css/pages/telaMestre.css" rel="stylesheet">
</head>
<body>

    <div class="container text-center">
        <div class="row align-items-start">
            <h2>Master Domain</h2>
            <div class="col">
                <form action="#" method="post">
                    <div class="form-group">
                        <label for="scene">Cênário</label>
                        <select class="form-control" id="scene" required>
                            <option value="">Selecione</option>
                            <option value="forest">Floresta</option>
                            <option value="mountain">Montanha</option>
                            <option value="cave">Caverna</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="time">Tempo</label>
                        <select class="form-control" id="time" required>
                            <option value="">Selecione</option>
                            <option value="day">Dia</option>
                            <option value="night">Noite</option>
                        </select>
                    </div>
                </form>
                
                <!-- <img src="assets/images/dice2.png" alt="dado"> -->
                <div class="dice">
                    <?php echo '<span class="dice-result">'.$numDado.'</span>'?>
                </div>
                
            </div>
            <div class="col">
                <form action="#" method="post">
                    <label for="insert">Inserir</label>
                        <select class="form-control" id="insert" required>
                            <option value="">Selecione</option>
                            <option value="goblin">Goblin</option>
                            <option value="golen">Golen</option>
                            <option value="dragon">Dragão</option>
                        </select>
                </form>
                <div class="dropdown">
                    <button onclick="myFunction()" class="dropbtn">Atributos</button>
                    <div id="myDropdown" class="dropdown-content">
                      <a href="#">Habilidades</a>
                      <a href="#">Itens</a>
                      <a href="#">Status</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>

        /* When the user clicks on the button,
        toggle between hiding and showing the dropdown content */
        function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
        }

        // Close the dropdown menu if the user clicks outside of it
        window.onclick = function(event) {
            if (!event.target.matches('.dropbtn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }

        let diceSidesArray = [6, 12, 20]; // Três opções de dados
        let diceArrayIndex = 0;

        // Rolar o dado (botão esquerdo)
        function rollDice() {
            const dice   = document.querySelector('.dice-result');
            const result = Math.floor(Math.random() * diceSidesArray[diceArrayIndex]) + 1;

            dice.textContent = result; // O Número result aparece no centro do dado
            localStorage.setItem('diceResult', result); // Salva o result para ser usado em outras páginas
        }

        // Muda o formato do dado e o número de lados (botão direito)
        function changeDiceShape(event) {
            event.preventDefault(); // Evita de aparecer o menuzinho

            const diceElement = document.querySelector('.dice');
            diceArrayIndex = (diceArrayIndex + 1) % diceSidesArray.length;  

            const currentSides = diceSidesArray[diceArrayIndex];  

            if (currentSides === 6) {
                diceElement.classList.remove('hexagon');
                diceElement.classList.add('square');  // dado de 6 lados é um quadrado
            } else {
                diceElement.classList.remove('square');
                diceElement.classList.add('hexagon');  // dados de 12 e 20 lados são hexagonais
            }

            // Salva o formato do dado para ser usado em outras páginas
            localStorage.setItem('diceShape', currentSides); // O tamanho controla o formato
            
            rollDice(); // Role o dado uma vez no novo formato
        }
        
        // Atualiza o background baseado nas escolhas do mestre
        function updateBackground() {
            const scene = document.getElementById('scene').value;
            const time  = document.getElementById('time').value;

            // Escada de else if para somar os efeitos de dois dropdowns
            let backgroundImage = 'assets/images/table.jpg'; // A Imagem padrão é essa mesa

            if (scene === 'forest' && time === 'day') {
                backgroundImage = 'assets/images/dayForest.jpg';
            } else if (scene === 'forest' && time === 'night') {
                backgroundImage = 'assets/images/nightForest.jpg';
            } else if (scene === 'mountain' && time === 'day') {
                backgroundImage = 'assets/images/dayMountain.jpg';
            } else if (scene === 'mountain' && time === 'night') {
                backgroundImage = 'assets/images/nightMountain.jpg';
            } else if (scene === 'cave' && time === 'day') {
                backgroundImage = 'assets/images/dayCave.jpg';
            } else if (scene === 'cave' && time === 'night') {
                backgroundImage = 'assets/images/nightCave.jpg';
            }

            // Muda o background
            document.body.style.backgroundImage = `url('${backgroundImage}')`;

            // Armazena essa imagem no localStorage
            localStorage.setItem('selectedBackground', backgroundImage);
        }

        window.onload = function() {
            // Atracando um listener nos dropdowns de 'scene' e no 'time' 
            document.getElementById('scene').addEventListener('change', updateBackground);
            document.getElementById('time').addEventListener('change', updateBackground);

            // Evento de clico para rolar o dado
            document.querySelector('.dice').addEventListener('click', rollDice);
            // Evento com botão direito para mudar o formato do dado
            document.querySelector('.dice').addEventListener('contextmenu', changeDiceShape);
            
        }
        
    </script>
</body>
</html>