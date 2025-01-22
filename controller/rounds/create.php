<?php

require_once __DIR__ . '/../../models/Card.php';
require_once __DIR__ . '/../../models/Player.php';
require_once __DIR__ . '/../../models/Round.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $people_num = $_POST['people_num']; 
    $cards_in_hand = $people_num <= 13 ? 4 : 1; 

    $round = new Round();
    $round->save();
    $cards = Card::shuffledCards();

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
} else {
}

?>