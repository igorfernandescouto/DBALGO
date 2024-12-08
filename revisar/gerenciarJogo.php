
<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'db_connection.php';

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

function validateGameState($scene, $time, $diceSides) {
    $validScenes = ['forest', 'mountain', 'cave', ''];
    $validTimes = ['day', 'night', ''];
    $validDiceSides = [6, 12, 20];

    return in_array($scene, $validScenes) && 
           in_array($time, $validTimes) && 
           in_array($diceSides, $validDiceSides);
}

try {
    $conn = getDatabaseConnection();

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Fetch current game state
        $stmt = $conn->prepare("SELECT * FROM game_states ORDER BY id DESC LIMIT 1");
        $stmt->execute();
        $gameState = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo json_encode([
            'success' => true,
            'gameState' => $gameState
        ]);
    } 
    elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Parse incoming JSON data
        $data = json_decode(file_get_contents('php://input'), true);

        $scene = $data['scene'] ?? '';
        $time = $data['time'] ?? '';
        $diceSides = $data['diceSides'] ?? 6;

        // Validate game state
        if (!validateGameState($scene, $time, $diceSides)) {
            http_response_code(400);
            echo json_encode([
                'success' => false, 
                'message' => 'Invalid game state parameters'
            ]);
            exit;
        }

        // Update game state
        $stmt = $conn->prepare("INSERT INTO game_states (scene, time, current_dice_sides) VALUES (:scene, :time, :diceSides)");
        $stmt->bindParam(':scene', $scene);
        $stmt->bindParam(':time', $time);
        $stmt->bindParam(':diceSides', $diceSides, PDO::PARAM_INT);
        
        $result = $stmt->execute();

        echo json_encode([
            'success' => $result,
            'message' => $result ? 'Game state updated successfully' : 'Failed to update game state'
        ]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage()
    ]);
}
