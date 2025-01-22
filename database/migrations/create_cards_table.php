<?php
function createCardsTable($db) 
{
    $db->query("
        CREATE TABLE IF NOT EXISTS cards (
            id INT AUTO_INCREMENT PRIMARY KEY,
            code VARCHAR(5) NOT NULL,
            `rank` VARCHAR(2) NOT NULL,
            suit VARCHAR(1) NOT NULL
        )
    ");
    echo "Table Cards created successfully.\n";
}
