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

    // Preparar o insert com os parâmetros corretos
    $insert = $con->prepare('INSERT INTO persona (usuario, nomePersona, classe, forca, inteligencia, destreza, vida) VALUES (:usuario, :nomePersona, :classe, :forca, :inteligencia, :destreza, :vida)');
    $insert->bindParam(':usuario', $codigo);
    $insert->bindParam(':nomePersona', $nome);
    $insert->bindParam(':classe', $classe);
    $insert->bindParam(':forca', $forca);
    $insert->bindParam(':inteligencia', $inteligencia);
    $insert->bindParam(':destreza', $destreza);
    $insert->bindParam(':vida', $vida);

    // Executar o insert
    if($insert->execute()){
        header('Location: escolherJogo.php');
    } else {
        header('Location: criarPersonagem.php');
    }
}
?>

