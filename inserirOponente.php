<?php
include_once "conexao.php";

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $oponente = $_POST['oponente'];
    $codJogo = $_POST['codJogo'];
    $codigo = $_SESSION['codUsuario'];

    if ($oponente == "goblin"){
        $nome = "Goblin";
        $classe = "goblin";
        $forca = 30;
        $inteligencia = 10;
        $destreza = 25;
        $vida = 200;
    } elseif ($oponente == "golen"){
        $nome = "Golen";
        $classe = "golen";
        $forca = 80;
        $inteligencia = 30;
        $destreza = 10;
        $vida = 400;
    } elseif ($oponente == "dragon"){
        $nome = "Dragao";
        $classe = "dragon";
        $forca = 100;
        $inteligencia = 60;
        $destreza = 50;
        $vida = 1000;
    } else {
        echo "Oponente inválido.";
        header("location:telaMestre.php?codJogo=$codJogo");
    }

    $insert = $con->prepare('INSERT INTO persona (nomePersona, classe, forca, inteligencia, destreza, vida, usuario) VALUES (:nome, :classe, :forca, :inteligencia, :destreza, :vida, :usuario)');
        $insert->bindParam(':nome', $nome);
        $insert->bindParam(':classe', $classe);
        $insert->bindParam(':forca', $forca);
        $insert->bindParam(':inteligencia', $inteligencia);
        $insert->bindParam(':destreza', $destreza);
        $insert->bindParam(':vida', $vida);
        $insert->bindParam(':usuario', $codigo);
    
    if($insert->execute()){
        $select = $con->prepare('SELECT codPersona, classe FROM persona WHERE classe = :classe');
        $select->bindParam(':classe', $oponente);
        $select->execute();
        while ($result = $select->fetch()) {
            $codOponente=$result['codPersona'];  
        }

        $update = $con->prepare('UPDATE jogo SET oponente = :oponente WHERE codJogo = :codJogo');
        $update->bindParam(':oponente', $codOponente);
        $update->bindParam(':codJogo', $codJogo);
        $update->execute();

        header("location:telaMestre.php?codJogo=$codJogo");  
    } else {
        echo "Insert";
    }

      
}
?>