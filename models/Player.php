<?php

include __DIR__ . '/../database/db_connection.php';
require_once __DIR__ . '/../vendor/Model.php';

class Player extends Model 
{
    // Public properties representing Player attributes
    public $id;
    public $player_num;
    public $round_id;

    // Private property for the database connection
    private $db;

    /**
     * Constructor method to initialize a Player object.
     *
     * @param int|null $id The ID of the player to load. If null, creates a new Player instance without loading from the database.
     * @throws Exception If a player with the provided ID is not found in the database.
     */
    public function __construct($id = null) {
        global $db; 
        $this->db = $db;
        
        // If ID provided => load the card from db if found, otherwise, throw an exception 
        if ($id) {
            $query = "SELECT * FROM players WHERE id = '$id'";
            $result = $this->db->query($query);

            if ($result && $row = $result->fetch_assoc()) {
                $this->setAttributes($row);
            } else {
                throw new Exception("Player with ID $id not found");
            }
        }
    }


    /**
     * Saves the Player object to the database.
     *
     * @return $this The Player object with updated attributes.
     * @throws Exception If the player could not be created in the database.
     */
    public function save()
    {
        // Insert new player
        $query = "INSERT INTO players (player_num, round_id) VALUES ('$this->player_num', '$this->round_id')";
        $this->db->query($query);

        if ($this->db->affected_rows <= 0) {
            throw new Exception("Failed to create player");
        }

        // get the player's ID to the newly inserted ID, then return from db
        $this->id = $this->db->insert_id;
        $query = "SELECT * FROM players WHERE id = '$this->id'";
        $result = $this->db->query($query);

        // If the player is found, set its attributes
        if ($result && $row = $result->fetch_assoc()) 
        {
            $this->setAttributes($row);
        }

        return $this;
    }

    /**
     * Retrieves all cards assigned to the player.
     *
     * @return array An array of Card objects associated with the player.
     */
    public function cards() 
    {
        $query = "
            SELECT c.* FROM player_cards pc
            JOIN cards c ON pc.card_id = c.id
            WHERE pc.player_id = $this->id
        ";
        $result = $this->db->query($query);

        $cards = [];
        // If query succeful, create Card objects for each attached card
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $card = new Card();
                $card->setAttributes($row);
                $cards[] = $card;
            }
        }

        return $cards;
    }

    /**
     * Adds a card to the player's hand.
     *
     * @param int $cardId The ID of the card to add to the player.
     * @return bool True if the card was successfully added.
     * @throws Exception If the card could not be added to the player.
     */
    public function addCard($cardId) 
    {
        $query = "INSERT INTO player_cards (player_id, card_id) VALUES ($this->id, $cardId)";
        $this->db->query($query);
        if ($this->db->affected_rows <= 0) 
        {
            throw new Exception("Failed to add card to player");
        }
        return true;
    }    

}
?>
