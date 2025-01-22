<?php

require_once __DIR__ . '/../../models/Round.php';

function showTable($round)
{   
    // Start table
    echo '<table class="table table-striped mt-4">';
    echo '<thead class="table">';
    echo '<tr>';
    echo '<th scope="col">Player</th>';
    echo '<th scope="col">Cards</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    //  table rows with round data
    foreach ($round->players() as $player) 
    {
        echo '<tr>';
        echo '<th scope="row">' . $player->player_num . '</th>';
        echo '<td>';
        foreach ($player->cards() as $card) 
        {
            echo "($card->code) ";
        }
        echo '</td>';
        echo '</tr>';
    }

    // End table
    echo '</tbody>';
    echo '</table>';
}

?>