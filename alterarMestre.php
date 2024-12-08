<!-- Alterar boolean mestre do Jogador -->

<?php
    include_once "conexao.php";
    date_default_timezone_set('America/Sao_Paulo');

    session_start(); 
    $codigo = $_SESSION['codUsuario'];

    try {
        $select = $con->prepare("SELECT * FROM usuario WHERE codUsuario = $codigo");
        $select->execute();

        while ($result = $select->fetch()) {
            $mestre=$result['mestre'];  
        }

        $novo_mestre = ($mestre == 1) ? 0 : 1; 

        $update=$con->prepare('UPDATE usuario SET mestre=:mestre WHERE codUsuario=:codigo');
        $update->bindParam(':mestre',$novo_mestre);
        $update->bindParam(':codigo',$codigo);

        // executar o update
        $update->execute();
        header('location:escolherJogo.php');

    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
?>