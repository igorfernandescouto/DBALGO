<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Jogo</title>
    <link rel="stylesheet" href="assets/css/pages/criarJogo.css">
</head>

<body>
    <h1>Criar Jogo</h1>
    <div>
        <form action="gravarJogo.php" method="get">
            <label for="codigo">ID usuário</label>
            <input type="text" name="codigo" id="codigo" value=<?php session_start(); echo $_SESSION['codUsuario']; ?> readonly>
            <br>
            <label for="cenario">Cenário</label>
              <select class="form-control" name="cenario" id="cenario" required>
                <option value="dayForest" selected>Floresta</option>
                <option value="dayMountain">Montanha</option>
                <option value="nightCave">Caverna</option>
              </select>
            <br>
            <label for="ladosDado">Lados do Dado</label>
              <select class="form-control" name="ladosDado" id="ladosDado" required>
                <option value="6">6</option>
                <option value="12" selected>12</option>
                <option value="20">20</option>
              </select>
            <br><br>
            <input type="submit" value="Enviar">
        </form>
    </div>
</body>

</html>