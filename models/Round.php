<?php

include __DIR__ . '/../database/db_connection.php';
require_once __DIR__ . '/../vendor/Model.php';

class Round extends Model 
{
    // Public properties representing round attributes
    public $id;
    public $created_at;

    // Private property for the database connection
    private $db;

    /**
     * Constructor method to initialize a Round object.
     *
     * @param int|null $id The ID of the round to load. If null, creates a new Round instance without loading from the database.
     * @throws Exception If a round with the provided ID is not found in the database.
     */
    public function __construct($id = null) {
        global $db; 
        $this->db = $db;

        // If an ID is provided, load the round data from the database
        if ($id) {

            $query = "SELECT * FROM rounds WHERE id = '$id'";
            $result = $this->db->query($query);

            if ($result && $row = $result->fetch_assoc()) 
            {
                $this->setAttributes($row);
            } 
            else 
            {
                throw new Exception("Round with ID $id not found");
            }
        }
    }

    /**
     * Saves the Player object to the database.
     *
     * @return $this The Player object with updated attributes.
     * @throws Exception If the player could not be created in the database.
     */
    static public function all() 
    {
        global $db;

        $query = "SELECT * FROM rounds";
        $result = $dbs->query($query);
    
        $rounds = [];
        // if the query is successful => fetch each card and add it to the array
        if ($result) 
        {
            while ($row = $result->fetch_assoc()) 
            {
                $rounds[] = (new self())->setAttributes($row);
            }
        }
        return $rounds;
    }
    

    /**
     * Saves the Round object to the database.
     *
     * @return $this The Round object with updated attributes.
     * @throws Exception If the round could not be created in the database.
     */
    public function save() {

        $query = "INSERT INTO rounds () VALUES ()";
        $this->db->query($query);

        if ($this->db->affected_rows <= 0) {
            throw new Exception("Failed to create round");
        }

        // get the player's ID to the newly inserted ID, then return from db
        $this->id = $this->db->insert_id;

        $query = "SELECT * FROM rounds WHERE id = '$this->id'";
        $result = $this->db->query($query);

        // If the player is found, set its attributes
        if ($result && $row = $result->fetch_assoc()) {
            $this->setAttributes($row);
        }

        return $this;
    }

    /**
     * Retrieves all players associated with the round.
     *
     * @return array An array of Player objects linked to the round.
     */
    public function players() 
    {
        $query = "SELECT * FROM players WHERE round_id = '$this->id'";
        $result = $this->db->query($query);

        $players = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $player = new Player($row['id']);
                $players[] = $player;
            }
        }

        return $players;
    }

     /**
     * Adds a new player to the round.
     *
     * @param int $player_num The player number to assign to the new player.
     * @return Player|null The newly created Player object, or null if creation failed.
     */
    public function addPlayer($player_num) 
    {
        try {
            $player = new Player();
            // Assign the player number and associate with the current round
            $player->player_num = $player_num;
            $player->round_id = $this->id;
            // Save the player AND RETURN
            $player->save();
            return $player;
        } catch (\Throwable $th) {
            echo $th;
        }
    }
}
?>
