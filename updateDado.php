<?php
include 'conexao.php';
session_start();


if (!isset($_SESSION['codUsuario']) || !isset($_SESSION['codJogo'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Acesso indevido']);
    exit;
}

$codUsuario = $_SESSION['codUsuario'];
$codJogo = $_SESSION['codJogo'];

// Gambi pra ter certeza que o usuário é mestre. Deveria existir um autenticar.php
$stmt = $conn->prepare("SELECT mestre FROM jogo WHERE codJogo = ?");
$stmt->bind_param('i', $codJogo);
$stmt->execute();
$result = $stmt->get_result();
$gameData = $result->fetch_assoc();

if ($gameData['mestre'] != $codUsuario) {
    http_response_code(403);
    echo json_encode(['error' => 'Apenas o mestre da mesa pode afetar o dado']);
    exit;
}

// Update no dado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $diceSides = $_POST['ladosDado'];
    $diceValue = $_POST['numDado'];

    $updateStmt = $conn->prepare("UPDATE jogo SET ladosDado = ?, numDado = ? WHERE codJogo = ?");
    $updateStmt->bind_param('iii', $diceSides, $diceValue, $codJogo);

    if ($updateStmt->execute()) {
        echo json_encode(['success' => true, 'numDado' => $diceValue]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Alguma coisa quebrou']);
    }
    exit;
}

// Se não precisar atualizar então da GET no que já existe
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode(['numDado' => $gameData['numDado'], 'ladosDado' => $gameData['ladosDado']]);
    exit;
}
?>
