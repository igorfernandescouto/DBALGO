<?php
    include_once "conexao.php";
    date_default_timezone_set('America/Sao_Paulo');

    $codJogo = $_GET['codJogo'];
    $codPersona = $_GET['codPersona'];

    $select = $con->prepare("SELECT * FROM persona p WHERE p.codPersona = $codPersona");
    $select->execute();

    while ($result = $select->fetch()) {
        $codigo=$result['usuario'];
        $nome=$result['nomePersona'];
        $classe=$result['classe'];
        $forca=$result['forca'];
        $inteligencia=$result['inteligencia'];
        $destreza=$result['destreza'];
        $vida=$result['vida'];
    }
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edição de Personagem - RPG</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <link href="assets/css/common.css" rel="stylesheet">
  <link href="assets/css/pages/criarPersonagem.css" rel="stylesheet">
</head>

<body>
  <div class="container">
    <div class="card">
      <h2>Edição de Personagem</h2>
      <form action="editaPersonagem.php?" method="get">
      <input type="hidden" name="codJogo" value="<?php echo $codJogo; ?>">
      <input type="hidden" name="codPersona" value="<?php echo $codPersona; ?>">
        <!-- Código do jogador -->
        <div class="form-group">
          <label for="codigo">Jogador</label>
          <input type="text" class="form-control"  name="codigo" id="codigo" value=<?php echo $codigo; ?> readonly>
        </div>

        <!-- Nome do Personagem -->
        <div class="form-group">
          <label for="nome">Nome do Personagem</label>
          <input type="text" class="form-control" maxlenght="100" name="nome" id="nome" value=<?php echo $nome;?> required>
        </div>

        <!-- Status do Personagem -->
        <div class="Status">
          <label for="forca">Força</label>
          <input type="number" class="form-control" min="0" max="130" name="forca" id="forca" value=<?php echo $forca;?> required>
          <label for="inteligencia">Inteligência</label>
          <input type="number" class="form-control" min="0" max="100" name="inteligencia" id="inteligencia" value=<?php echo $inteligencia;?> required>
          <label for="destreza">Destreza</label>
          <input type="number" class="form-control" min="0" max="100" name="destreza" id="destreza" value=<?php echo $destreza;?> required>
          <label for="vida">Vida</label>
          <input type="number" class="form-control" min="0" max="2000000000" name="vida" id="vida" value=<?php echo $vida;?> required>
        </div>

        <div class="row">
            <label for="classe">Classe</label>
            <input type="text" class="form-control" maxlenght="30" name="classe" id="classe" value=<?php echo $classe; ?> readonly>
        </div>

        <!-- Botão -->
        <button type="submit" class="btn btn-primary w-100">Editar Personagem</button>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/pages/criarPersonagem.js"></script>
</body>

</html>