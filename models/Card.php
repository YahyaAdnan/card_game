<?php

include __DIR__ . '/../database/db_connection.php';
require_once __DIR__ . '/../vendor/Model.php';

class Card extends Model 
{
    // Public properties representing card attributes
    public $id;
    public $code;
    public $suit;
    public $rank;

    // Private property for the database connection
    private $db;

    /**
     * Constructor method to initialize a Card object.
     *
     * @param int|null $id The ID of the card to load. If null, creates a new Card instance without loading from the database.
     * @throws Exception If a card with the provided ID is not found in the database.
     */
    public function __construct($id = null)
    {
        global $db; 
        $this->db = $db;

        // If ID provided => load the card from db if found, otherwise, throw an exception 
        if ($id) 
        {
            $query = "SELECT * FROM cards WHERE id = '$id'";
            $result = $this->db->query($query);
    
            if ($result && $row = $result->fetch_assoc()) {
                $this->setAttributes($row);
            } else {
                throw new Exception("Card with ID $id not found");
            }
        }
    }

    /**
     * Retrieves all cards from the database.
     *
     * @return array An array of Card objects.
     */
    static public function all() 
    {
        global $db;

        $query = "SELECT * FROM cards";
        $result = $db->query($query);

        $cards = [];
        // if the query is successful => fetch each card and add it to the array
        if ($result) 
        {
            while ($row = $result->fetch_assoc()) 
            {
                $cards[] = (new self())->setAttributes($row);
            }
        }

        return $cards;
    }

    /**
     * Retrieves all cards from the database and returns them in a shuffled order.
     *
     * @return array An array of shuffled Card objects.
     */
    static public function shuffledCards() 
    {
        $cards = self::all();
        shuffle($cards);
        return $cards;
    }

}
?>
