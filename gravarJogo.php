<?php
include_once "conexao.php";

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $codigo = $_GET['codigo'];
    $cenario = $_GET['cenario'];
    $ladosDado = $_GET['ladosDado'];

    $select = $con->prepare("SELECT * FROM usuario WHERE codUsuario = $codigo");
    $select->execute();

    while ($result = $select->fetch()) {
        $mestre=$result['mestre'];  
    }

    // Preparar o insert com os parâmetros corretos
    if($mestre == 1){
        $insert = $con->prepare('INSERT INTO jogo (mestre, cenario, ladosDado, numDado) VALUES (:mestre, :cenario, :ladosDado, 1)');
        $insert->bindParam(':mestre', $codigo);
        $insert->bindParam(':cenario', $cenario);
        $insert->bindParam(':ladosDado', $ladosDado);

        if($insert->execute()){
            $select = $con->prepare("SELECT codJogo FROM jogo WHERE mestre = $codigo");
            $select->execute();

            while ($result = $select->fetch()) {
                $codJogo=$result['codJogo'];  
            }
            header("Location: telaMestre.php?codJogo=$codJogo");
        } else {
            header('Location: criarJogo.php');
        }
    } else {
        header('Location: escolherJogo.php');
    }
}
?>