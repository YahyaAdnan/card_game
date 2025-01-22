<?php
function createRoundsTable($db) 
{
    $db->query("
        CREATE TABLE IF NOT EXISTS rounds (
            id INT AUTO_INCREMENT PRIMARY KEY,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
    echo "Table Matches created successfully.\n";
}