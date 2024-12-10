<?php
    include_once "conexao.php";
    date_default_timezone_set('America/Sao_Paulo');

    session_start();

    $codigo = $_SESSION['codUsuario'];
    $codJogo = $_GET['codJogo'];
    $codPersona = $_GET['codPersona'];

    

    try {
        $update=$con->prepare('UPDATE usuario SET personagem=:personagem WHERE codUsuario=:codigo');
        $update->bindParam(':personagem',$codPersona);
        $update->bindParam(':codigo',$codigo);
        $update->execute();

        $select = $con->prepare("SELECT player1, player2, player3 FROM jogo WHERE codJogo = $codJogo");
        $select->execute();
        $result = $select->fetch(PDO::FETCH_ASSOC);

        $num = null;
        foreach ($result as $coluna => $valor) {
            if (empty($valor)) { 
                // Extrai o número da coluna 
                preg_match('/player(\d+)/', $coluna, $matches); 
                $nume = $matches[1]; // guarda o número final na variável 
                break; // para o laço após encontrar a primeira coluna vazia 
            } 
        } 

        $select = $con->prepare("SELECT player1, player2, mestre FROM jogo WHERE codJogo = $codJogo");
        $select->execute();
        while ($result = $select->fetch()) {
            $player1=$result['player1'];
            $player2=$result['player2']; 
            $mestre=$result['mestre']; 
        }

        if ($codigo != $mestre){
            if ($nume !== null) {

                if ($nume == 1) {  
                    $update=$con->prepare('UPDATE jogo SET player1=:jogador WHERE codJogo=:jogo');
                } elseif ($nume == 2) {  
                    if($codigo != $player1){
                        $update=$con->prepare('UPDATE jogo SET player2=:jogador WHERE codJogo=:jogo');
                    } else {
                        header("location:join.php?codJogo=$codJogo");
                        echo '<script type="text/javascript">', 'alert("Usuário repetido!");', '</script>';
                    }
                } else {  
                    if($codigo != $player1 AND $codigo != $player2){
                        $update=$con->prepare('UPDATE jogo SET player3=:jogador WHERE codJogo=:jogo');
                    } else {
                        header("location:join.php?codJogo=$codJogo");
                        echo '<script type="text/javascript">', 'alert("Usuário repetido!");', '</script>';
                    }
                }
                
                $update->bindParam(':jogador',$codigo);
                $update->bindParam(':jogo',$codJogo);
                $update->execute();

                header("location:telaJogadores.php?codJogo=$codJogo");
            } else { 
                header("location:join.php?codJogo=$codJogo");
                echo '<script type="text/javascript">', 'alert("Sala cheia!");', '</script>';
            }
        } else{
            header("location:join.php?codJogo=$codJogo");
            echo '<script type="text/javascript">', 'alert("Usuário repetido!");', '</script>';
        }
        
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
    

?>

<!-- Agora devemos adicionar o codPersona na variável usuario.personagem, adicionar o usuário à mesa (verificando se não está cheia) e colocá-lo na telaJogadores -->
