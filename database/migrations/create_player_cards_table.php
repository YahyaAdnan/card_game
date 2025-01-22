<?php
function createPlayerCardsTable($db) 
{
    $db->query("
        CREATE TABLE IF NOT EXISTS player_cards (
            id INT AUTO_INCREMENT PRIMARY KEY,
            card_id INT NOT NULL,
            player_id INT NOT NULL,
            FOREIGN KEY (card_id) REFERENCES cards(id) ON DELETE CASCADE,
            FOREIGN KEY (player_id) REFERENCES players(id) ON DELETE CASCADE
        )
    ");
    echo "Table `player_cards` created successfully.\n";
}