<?php
include_once "conexao.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $oponente = $_POST['oponente'];
    $codJogo = $_POST['codJogo'];

    // Definindo os oponentes pré-criados
    $oponentes = [
        'goblin' => [
            'nome' => 'Goblin',
            'classe' => 'Monstro',
            'forca' => 10,
            'inteligencia' => 5,
            'destreza' => 8,
            'vida' => 30
        ],
        'golem' => [
            'nome' => 'Golem',
            'classe' => 'Monstro',
            'forca' => 20,
            'inteligencia' => 3,
            'destreza' => 5,
            'vida' => 50
        ],
        'dragao' => [
            'nome' => 'Dragão',
            'classe' => 'Monstro',
            'forca' => 30,
            'inteligencia' => 15,
            'destreza' => 10,
            'vida' => 100
        ]
    ];

    if (array_key_exists($oponente, $oponentes)) {
        $dadosOponente = $oponentes[$oponente];

        // Preparar o insert com os parâmetros corretos
        $insert = $con->prepare('INSERT INTO persona (nomePersona, classe, forca, inteligencia, destreza, vida) VALUES (:nome, :classe, :forca, :inteligencia, :destreza, :vida)');
        $insert->bindParam(':nome', $dadosOponente['nome']);
        $insert->bindParam(':classe', $dadosOponente['classe']);
        $insert->bindParam(':forca', $dadosOponente['forca']);
        $insert->bindParam(':inteligencia', $dadosOponente['inteligencia']);
        $insert->bindParam(':destreza', $dadosOponente['destreza']);
        $insert->bindParam(':vida', $dadosOponente['vida']);

        // Executar o insert
        if ($insert->execute()) {
            // Recuperar o código do oponente inserido
            $codOponente = $con->lastInsertId();

            // Verificar se o código do oponente foi recuperado corretamente
            if ($codOponente) {
                // Atualizar a tabela jogo com o código do oponente
                $update = $con->prepare('UPDATE jogo SET oponente = :oponente WHERE codJogo = :codJogo');
                $update->bindParam(':oponente', $codOponente);
                $update->bindParam(':codJogo', $codJogo);

                if ($update->execute()) {
                    echo "Oponente inserido com sucesso no jogo. Código do oponente: " . $codOponente;
                } else {
                    echo "Erro ao atualizar o jogo com o oponente.";
                }
            } else {
                echo "Erro ao recuperar o código do oponente inserido.";
            }
        } else {
            echo "Erro ao inserir oponente.";
        }
    } else {
        echo "Oponente inválido.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserir Oponente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Inserir Oponente</h2>
        <form action="inserirOponente.php" method="post">
            <div class="form-group">
                <label for="oponente">Selecione o Oponente</label>
                <select class="form-control" id="oponente" name="oponente" required>
                    <option value="">Selecione</option>
                    <option value="goblin">Goblin</option>
                    <option value="golem">Golem</option>
                    <option value="dragao">Dragão</option>
                </select>
            </div>
            <div class="form-group">
                <label for="codJogo">Código do Jogo</label>
                <input type="text" class="form-control" id="codJogo" name="codJogo" required>
            </div>
            <button type="submit" class="btn btn-primary">Inserir</button>
        </form>
    </div>
</body>
</html>