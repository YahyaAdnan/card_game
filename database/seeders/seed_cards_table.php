<?php
function CardsSeeder($db)
{
    $cardsExist = $db->query("SELECT COUNT(*) AS count FROM cards")->fetch_assoc()['count'];
    if ($cardsExist == 0)
    {
        $db->query("
            INSERT INTO cards (code, `rank`, suit)
            SELECT CONCAT(suit, '-', `rank`) AS code, `rank`, suit
            FROM (
                SELECT 'A' AS `rank` UNION ALL SELECT '2' UNION ALL SELECT '3'
                UNION ALL SELECT '4' UNION ALL SELECT '5' UNION ALL SELECT '6'
                UNION ALL SELECT '7' UNION ALL SELECT '8' UNION ALL SELECT '9'
                UNION ALL SELECT 'X' UNION ALL SELECT 'J' UNION ALL SELECT 'Q'
                UNION ALL SELECT 'K'
            ) ranks, (
                SELECT 'S' AS suit UNION ALL SELECT 'H' UNION ALL SELECT 'D'
                UNION ALL SELECT 'C'
            ) suits
        ");
        echo "Cards table seeded successfully.\n";
    } 
    else
    {
        echo "Cards table already seeded.\n";
    }
}
