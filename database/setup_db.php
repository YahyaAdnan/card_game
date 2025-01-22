<?php
include 'db_connection.php';

try 
{
    echo $dbname;
    // Run migrations
    require_once 'migrations/create_cards_table.php';
    require_once 'migrations/create_rounds_table.php';
    require_once 'migrations/create_players_table.php';
    require_once 'migrations/create_player_cards_table.php';

    $db->query("CREATE DATABASE IF NOT EXISTS $dbname");
    $db->query("USE $dbname");

    echo "Running migrations...\n";
    createCardsTable($db);
    createRoundsTable($db);
    createPlayersTable($db);
    createPlayerCardsTable($db);

    // Run seeders
    echo "Running seeders...\n";
    require_once 'seeders/seed_cards_table.php';
    CardsSeeder($db);

    echo "Database setup completed successfully.\n";

} 
catch (Exception $e) 
{
    die("Setup failed: " . $e->getMessage());
}

$db->close();
?>
