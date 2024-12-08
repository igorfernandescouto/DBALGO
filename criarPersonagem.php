<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Criação de Personagem - RPG</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <link href="assets/css/common.css" rel="stylesheet">
  <link href="assets/css/pages/criarPersonagem.css" rel="stylesheet">
</head>

<body>
  <div class="container">
    <div class="card">
      <h2>Criação de Personagem</h2>
      <form action="gravaPersonagem.php" method="get">
        <!-- Código do jogador -->
        <div class="form-group">
          <label for="codigo">Jogador</label>
          <input type="text" class="form-control"  name="codigo" id="codigo" value=<?php session_start(); echo $_SESSION['codUsuario']; ?> readonly>
        </div>

        <!-- Nome do Personagem -->
        <div class="form-group">
          <label for="nome">Nome do Personagem</label>
          <input type="text" class="form-control" maxlenght="100" name="nome" id="nome" placeholder="Nome do personagem" required>
        </div>

        <!-- Status do Personagem -->
        <div class="Status">
          <label for="forca">Força</label>
          <input type="number" class="form-control" min="0" max="130" name="forca" id="forca" placeholder="Pontos de Força" required>
          <label for="inteligencia">Inteligência</label>
          <input type="number" class="form-control" min="0" max="100" name="inteligencia" id="inteligencia" placeholder="Pontos de Inteligência" required>
          <label for="destreza">Destreza</label>
          <input type="number" class="form-control" min="0" max="100" name="destreza" id="destreza" placeholder="Pontos de Destreza" required>
          <label for="vida">Vida</label>
          <input type="number" class="form-control" min="0" max="2000000000" name="vida" id="vida" placeholder="Pontos de Vida" required>
        </div>

        <div class="row">
          <div class="col-md-8">
            <!-- Classe do jogador -->
            <div class="form-group">
              <label for="classe">Classe</label>
              <select class="form-control" name="classe" id="classe" required>
                <option value="">Selecione uma classe</option>
                <option value="guerreiro">Guerreiro</option>
                <option value="mago">Mago</option>
                <option value="arqueiro">Arqueiro</option>
                <option value="paladino">Paladino</option>
                <option value="ladino">Ladino</option>
                <option value="clerigo">Clérigo</option>
              </select>
            </div>
          </div>

          <!-- Preview da classe
          <div class="col-md-4">
            <div class="class-preview">
              <div id="shapeContainer" class="shape square"></div>
              <div class="class-name">Classe: <span id="selectedClass">Nenhuma</span></div>
            </div>
          </div> -->
        </div>

        <!-- Botão -->
        <button type="submit" class="btn btn-primary w-100">Criar Personagem</button>

        <a type="button" class="btn btn-primary w-100" href="escolherJogo.php">Escolher a mesa</a>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/pages/criarPersonagem.js"></script>
</body>

</html>
