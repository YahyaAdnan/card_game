<?php

require_once __DIR__ . '/../../models/Card.php';
require_once __DIR__ . '/../../models/Player.php';
require_once __DIR__ . '/../../models/Round.php';
require_once __DIR__ . '/show.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    // Get the people_num from the POST data, then we define cards in hand.
    $people_num = $_POST['people_num']; 
    $cards_in_hand = $people_num <= 13 ? 4 : 1; 

    // create ROUND.
    $round = new Round();
    $round->save();

    // Get a shuffled  cards
    $cards = Card::shuffledCards();

    //loop each player => create player, take the top card(s) from the deck 
    for ($i = 1; $i <= $people_num; $i++) 
    {
        $player = $round->addPlayer($i);
        for ($j = 0; $j < $cards_in_hand; $j++) 
        {
            $card = array_pop($cards);

            if ($card) 
            {
                $player->addCard($card->id); 
            }
        }
    }
    
    // Display the game table
    showTable($round);
    exit();
}

http_response_code(400);
echo json_encode(["error" => "Invalid request"]);
?>