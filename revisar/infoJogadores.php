
<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once 'db_connection.php';

function getCharacterDetails($characterId) {
    $conn = getDatabaseConnection();
    
    try {
        // Fetch character details
        $detailsStmt = $conn->prepare(
            "SELECT level, strength, dexterity, intelligence, vitality 
             FROM character_details 
             WHERE id = :character_id"
        );
        $detailsStmt->bindParam(':character_id', $characterId);
        $detailsStmt->execute();
        $details = $detailsStmt->fetch(PDO::FETCH_ASSOC);

        // Fetch skills
        $skillsStmt = $conn->prepare(
            "SELECT skill_name, skill_level 
             FROM character_skills 
             WHERE character_id = :character_id"
        );
        $skillsStmt->bindParam(':character_id', $characterId);
        $skillsStmt->execute();
        $skills = $skillsStmt->fetchAll(PDO::FETCH_ASSOC);

        // Fetch inventory
        $inventoryStmt = $conn->prepare(
            "SELECT item_name, item_type 
             FROM character_inventory 
             WHERE character_id = :character_id"
        );
        $inventoryStmt->bindParam(':character_id', $characterId);
        $inventoryStmt->execute();
        $inventory = $inventoryStmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'details' => $details,
            'skills' => $skills,
            'inventory' => $inventory
        ];
    } catch (PDOException $e) {
        return ['error' => $e->getMessage()];
    }
}

// Handle API request
$characterId = $_GET['character_id'] ?? null;
if ($characterId) {
    $result = getCharacterDetails($characterId);
    echo json_encode($result);
}
?>

