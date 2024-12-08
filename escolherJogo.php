<link rel="stylesheet" href="assets/css/pages/escolherJogo.css">
<?php
    //incluir o arquivo de conexão com o banco
    include_once "conexao.php";
    date_default_timezone_set('America/Sao_Paulo');
    
    try {
        $select = $con->prepare("SELECT * FROM jogo");
        $select->execute();
        ?> 
        <!-- html -->
        <h1 style="text-align: center;">Mesas ativas</h1>
        <table border="1" style="border-collapse: collapse; margin: auto">
            <tr>
                <th>Mesa</th>
                <th>Mestre</th>
                <th>Entrar</th>
            </tr>

        <?php
        while ($result = $select->fetch()) {
            $codJogo=$result['codJogo'];
            $mestre=$result['mestre'];

            echo "<tr>";
                echo "<td>".$codJogo."</td>";
                echo "<td>".$mestre."</td>";
                echo "<td style='text-align:center;'><a href='join.php?codJogo=$codJogo'><img src='assets/images/join.png' style='width: 40%;' title='Join'></a></td>";
            echo "</tr>";    
                
        }
        
        echo "</table>";

        echo "<a href='alterarMestre.php'><img src='assets/images/cap.png' title='Alterar mestre'></a>";

        echo "<a href='criarJogo.php'><img src='assets/images/desk.png' title='Criar mesa'></a>";


    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }


?>