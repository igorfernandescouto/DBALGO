<?php
    include_once "conexao.php";
    date_default_timezone_set('America/Sao_Paulo');

    $codJogo = $_POST['codJogo'];
    $cenario = $_POST['scene'];

    try {
        $update=$con->prepare('UPDATE jogo SET cenario=:cenario WHERE codJogo=:codJogo');
        $update->bindParam(':cenario',$cenario);
        $update->bindParam(':codJogo',$codJogo);

        // executar o update
        $update->execute();
        header("location:telaMestre.php?codJogo=$codJogo");

    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
?>
