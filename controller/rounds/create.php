<?php

require_once __DIR__ . '/../../models/Card.php';
require_once __DIR__ . '/../../models/Player.php';
require_once __DIR__ . '/../../models/Round.php';

$round = new Round();
$round->save();

?>