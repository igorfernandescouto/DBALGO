
<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'db_connection.php';

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

try {
    $conn = getDatabaseConnection();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Parse incoming JSON data
        $data = json_decode(file_get_contents('php://input'), true);

        $diceSides = $data['diceSides'] ?? 6;
        
        // Validate dice sides
        $validDiceSides = [6, 12, 20];
        if (!in_array($diceSides, $validDiceSides)) {
            http_response_code(400);
            echo json_encode([
                'success' => false, 
                'message' => 'Invalid dice sides'
            ]);
            exit;
        }

        // Generate random roll
        $diceRoll = random_int(1, $diceSides);

        // Update last dice roll in database
        $stmt = $conn->prepare("UPDATE game_states SET last_dice_roll = :roll ORDER BY id DESC LIMIT 1");
        $stmt->bindParam(':roll', $diceRoll, PDO::PARAM_INT);
        $result = $stmt->execute();

        echo json_encode([
            'success' => true,
            'diceRoll' => $diceRoll
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

