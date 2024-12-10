<?php
include_once "conexao.php";

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $codigo = $_GET['codigo'];
    $nome = $_GET['nome'];
    $classe = $_GET['classe'];
    $forca = $_GET['forca'];
    $inteligencia = $_GET['inteligencia'];
    $destreza = $_GET['destreza'];
    $vida = $_GET['vida'];

    try {
        if ($classe == "guerreiro"){
            $nomeItem = "Espada";
            $forcaItem = 50;
            $inteligenciaItem = 0;
            $destrezaItem = 5;
            $vidaItem = 10;
            $nomeHabilidade = "Rage";
            $forcaHabilidade = 3;
            $inteligenciaHabilidade = 1;
            $destrezaHabilidade = 1;
            $vidaHabilidade = 2;
        } elseif ($classe == "mago"){
            $nomeItem = "Varinha";
            $forcaItem = 5;
            $inteligenciaItem = 50;
            $destrezaItem = 10;
            $vidaItem = 0;
            $nomeHabilidade = "Fogo";
            $forcaHabilidade = 1;
            $inteligenciaHabilidade = 4;
            $destrezaHabilidade = 1;
            $vidaHabilidade = 1;
        } elseif ($classe == "arqueiro"){
            $nomeItem = "Arco";
            $forcaItem = 50;
            $inteligenciaItem = 10;
            $destrezaItem = 5;
            $vidaItem = 0;
            $nomeHabilidade = "Saraivada";
            $forcaHabilidade = 3;
            $inteligenciaHabilidade = 1;
            $destrezaHabilidade = 2;
            $vidaHabilidade = 1;
        } elseif ($classe == "paladino"){
            $nomeItem = "Lanca";
            $forcaItem = 50;
            $inteligenciaItem = 0;
            $destrezaItem = 0;
            $vidaItem = 15;
            $nomeHabilidade = "Escudo";
            $forcaHabilidade = 1;
            $inteligenciaHabilidade = 1;
            $destrezaHabilidade = 1;
            $vidaHabilidade = 4;
        } elseif ($classe == "ladino"){
            $nomeItem = "Faca";
            $forcaItem = 40;
            $inteligenciaItem = 0;
            $destrezaItem = 20;
            $vidaItem = 5;
            $nomeHabilidade = "Agilidade";
            $forcaHabilidade = 1;
            $inteligenciaHabilidade = 1;
            $destrezaHabilidade = 4;
            $vidaHabilidade = 1;
        } elseif ($classe == "clerigo"){
            $nomeItem = "Clava";
            $forcaItem = 35;
            $inteligenciaItem = 10;
            $destrezaItem = 10;
            $vidaItem = 10;
            $nomeHabilidade = "Arca";
            $forcaHabilidade = 1;
            $inteligenciaHabilidade = 2;
            $destrezaHabilidade = 2;
            $vidaHabilidade = 2;
        } else {
            echo "Classe inválida.";
            header("location:criarPersonagem.php");
        }

        // Criar item
        $insert = $con->prepare('INSERT INTO item (nomeItem, forca, inteligencia, destreza, vida) VALUES (:nomeItem, :forcaItem, :inteligenciaItem, :destrezaItem, :vidaItem)');
        $insert->bindParam(':nomeItem', $nomeItem);
        $insert->bindParam(':forcaItem', $forcaItem);
        $insert->bindParam(':inteligenciaItem', $inteligenciaItem);
        $insert->bindParam(':destrezaItem', $destrezaItem);
        $insert->bindParam(':vidaItem', $vidaItem);
        $insert->execute();

        $select = $con->prepare('SELECT codItem, nomeItem FROM item WHERE nomeItem = :nomeItem');
        $select->bindParam(':nomeItem', $nomeItem);
        $select->execute();
        while ($result = $select->fetch()) {
            $item=$result['codItem'];  
        }

        echo $item;

        // Criar skill
        $insert = $con->prepare('INSERT INTO habilidade (nomeHabilidade, forca, inteligencia, destreza, vida) VALUES (:nomeHabilidade, :forcaHabilidade, :inteligenciaHabilidade, :destrezaHabilidade, :vidaHabilidade)');
        $insert->bindParam(':nomeHabilidade', $nomeHabilidade);
        $insert->bindParam(':forcaHabilidade', $forcaHabilidade);
        $insert->bindParam(':inteligenciaHabilidade', $inteligenciaHabilidade);
        $insert->bindParam(':destrezaHabilidade', $destrezaHabilidade);
        $insert->bindParam(':vidaHabilidade', $vidaHabilidade);
        $insert->execute();

        $select = $con->prepare('SELECT codHabilidade, nomeHabilidade FROM habilidade WHERE nomeHabilidade = :nomeHabilidade');
        $select->bindParam(':nomeHabilidade', $nomeHabilidade);
        $select->execute();
        while ($result = $select->fetch()) {
            $skill=$result['codHabilidade'];  
        }

        // Preparar o insert com os parâmetros corretos
        $insert = $con->prepare('INSERT INTO persona (usuario, nomePersona, classe, forca, inteligencia, destreza, vida, item, skill) VALUES (:usuario, :nomePersona, :classe, :forca, :inteligencia, :destreza, :vida, :item, :skill)');
        $insert->bindParam(':usuario', $codigo);
        $insert->bindParam(':nomePersona', $nome);
        $insert->bindParam(':classe', $classe);
        $insert->bindParam(':forca', $forca);
        $insert->bindParam(':inteligencia', $inteligencia);
        $insert->bindParam(':destreza', $destreza);
        $insert->bindParam(':vida', $vida);
        $insert->bindParam(':item', $item);
        $insert->bindParam(':skill', $skill);


        // Executar o insert
        if($insert->execute()){
            header('Location: escolherJogo.php');
        } else {
            header('Location: criarPersonagem.php');
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>

