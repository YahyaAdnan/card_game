<?php
function createPlayersTable($db)
{
    $db->query("
        CREATE TABLE IF NOT EXISTS players (
            id INT AUTO_INCREMENT PRIMARY KEY,
            player_num INT NOT NULL,
            round_id INT NOT NULL,
            FOREIGN KEY (round_id) REFERENCES rounds(id) ON DELETE CASCADE
        )
    ");
    echo "Table Players created successfully.\n";
}
