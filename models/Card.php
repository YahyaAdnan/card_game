<?php

namespace Models;

include 'db_connection.php';

class Card {
    
    public $id;
    public $code;
    public $suit;
    public $rank;

    public function __construct($id = null)
    {
        global $db; 
        $this->db = $db;

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

    static public function all($db) 
    {
        $query = "SELECT * FROM cards";
        $result = $db->query($query);

        $cards = [];
        if ($result) 
        {
            while ($row = $result->fetch_assoc()) 
            {
                $cards[] = (new self($db))->setAttributes($row);
            }
        }
        return $cards;
    }

    static public function shuffledCards($db) 
    {
        $cards = self::all($db);
        shuffle($cards);
        return $cards;
    }

    public function setAttributes($attributes) 
    {
        foreach ($attributes as $key => $value) 
        {
            if (property_exists($this, $key)) 
            {
                $this->$key = $value;
            }
        }
        return $this;
    }
}
?>
