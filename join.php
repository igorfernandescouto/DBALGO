<!-- Entrar na mesa com codPersona -->
<link rel="stylesheet" href="assets/css/pages/join.css">
<?php
    include_once "conexao.php";
    date_default_timezone_set('America/Sao_Paulo');

    $codJogo = $_GET['codJogo'];
    session_start();
    $codigo = $_SESSION['codUsuario'];

    $select = $con->prepare("SELECT * FROM persona WHERE usuario = $codigo");
    $select->execute();

    try {
        ?> 
        <!-- html -->
        <h1 style="text-align: center;">Personagens criados</h1>
        <table border="1" style="border-collapse: collapse; margin: auto">
            <tr>
                <th>Código</th>
                <th>Nome</th>
                <th>Classe</th>
                <th>Entrar</th>
            </tr>
        <?php
        while ($result = $select->fetch()) {
            $codPersona=$result['codPersona'];
            $nome=$result['nomePersona'];
            $classe=$result['classe'];

            echo "<tr>";
                echo "<td>".$codPersona."</td>";
                echo "<td>".$nome."</td>";
                echo "<td>".$classe."</td>";
                echo "<td style='text-align:center;'><a href='entrar.php?codPersona=$codPersona&codJogo=$codJogo'><img src='assets/images/join.png' title='Entrar na mesa'></a></td>";
            echo "</tr>";    
        }
        
        echo "</table>";
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }

?>