<?php
// sync.php - Enhanced Synchronization
require_once 'conexao.php';

function validateDiceInput($sides) {
    $validSides = [6, 12, 20];
    if (!in_array($sides, $validSides)) {
        handleError('Invalid dice sides: ' . $sides);
    }
}

function updateGameState($admin_id, $scene, $time, $background) {
    $conn = getDatabaseConnection();
    
    // Validate input
    $validScenes = ['forest', 'mountain', 'cave'];
    $validTimes = ['day', 'night'];
    
    if (!in_array($scene, $validScenes)) {
        handleError('Invalid scene: ' . $scene);
    }
    
    if (!in_array($time, $validTimes)) {
        handleError('Invalid time: ' . $time);
    }
    
    // Predefined background mapping
    $backgroundMap = [
        'forest' => [
            'day' => 'assets/images/dayForest.jpg',
            'night' => 'assets/images/nightForest.jpg'
        ],
        'mountain' => [
            'day' => 'assets/images/dayMountain.jpg',
            'night' => 'assets/images/nightMountain.jpg'
        ],
        'cave' => [
            'day' => 'assets/images/dayCave.jpg',
            'night' => 'assets/images/nightCave.jpg'
        ]
    ];
    
    // Validate and set background
    if (!isset($backgroundMap[$scene][$time])) {
        handleError('Invalid background combination');
    }
    $background = $backgroundMap[$scene][$time];
    
    // Check if game table exists for this admin
    $stmt = $conn->prepare("
        INSERT INTO game_tables (admin_id, scene, time, background_image) 
        VALUES (?, ?, ?, ?) 
        ON DUPLICATE KEY UPDATE 
        scene = VALUES(scene), 
        time = VALUES(time), 
        background_image = VALUES(background_image)
    ");
    
    $stmt->bind_param("isss", $admin_id, $scene, $time, $background);
    
    if ($stmt->execute()) {
        // Get the game table ID
        $game_table_id = $stmt->insert_id ?: $conn->insert_id;
        
        echo json_encode([
            'status' => 'success', 
            'message' => 'Game state updated',
            'game_table_id' => $game_table_id,
            'background' => $background
        ]);
    } else {
        handleError('Failed to update game state');
    }
    
    $stmt->close();
    $conn->close();
}