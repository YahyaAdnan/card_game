<?php

include __DIR__ . '/../database/db_connection.php';

class Player {

    public $id;
    public $player_num;
    public $round_id;
    private $db;

    public function __construct($id = null) {
        global $db; 
        $this->db = $db;
        
        if ($id) {
            // Fetch player details based on ID
            $query = "SELECT * FROM players WHERE id = '$id'";
            $result = $this->db->query($query);

            if ($result && $row = $result->fetch_assoc()) {
                $this->setAttributes($row);
            } else {
                throw new Exception("Player with ID $id not found");
            }
        }
    }

    // Save a new player or update an existing one
    public function save()
    {

        // Insert new player
        $query = "INSERT INTO players (player_num, round_id) VALUES ('$this->player_num', '$this->round_id')";
        $this->db->query($query);

        if ($this->db->affected_rows <= 0) {
            throw new Exception("Failed to create player");
        }

        $this->id = $this->db->insert_id;
        $query = "SELECT * FROM players WHERE id = '$this->id'";
        $result = $this->db->query($query);

        if ($result && $row = $result->fetch_assoc()) 
        {
            $this->setAttributes($row);
        }

        return $this;
    }

    public function setAttributes($attributes) {
        foreach ($attributes as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
        return $this;
    }

    public function round() {
        $query = "SELECT * FROM rounds WHERE id = '$this->round_id'";
        $result = $this->db->query($query);

        if ($result && $row = $result->fetch_assoc()) 
        {
            $round = new Round($this->db);
            $round->setAttributes($row);
            return $round;
        }

        return null;
    }

    public function cards() {
        $query = "
            SELECT c.* FROM player_cards pc
            JOIN cards c ON pc.card_id = c.id
            WHERE pc.player_id = $this->id
        ";
        $result = $this->db->query($query);

        $cards = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $card = new Card($this->db);
                $card->setAttributes($row);
                $cards[] = $card;
            }
        }

        return $cards;
    }

    public function addCard($cardId) {
        $query = "INSERT INTO player_cards (player_id, card_id) VALUES ($this->id, $cardId)";
        $this->db->query($query);
        if ($this->db->affected_rows <= 0) {
            throw new Exception("Failed to add card to player");
        }
        return true;
    }    

}
?>
