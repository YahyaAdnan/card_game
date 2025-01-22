<?php

namespace Models;

include 'db_connection.php';

class Round {

    public $id;
    public $created_at;
    private $db;

    public function __construct($id = null) {
        global $db; 
        $this->db = $db;

        if ($id) {

            $query = "SELECT * FROM rounds WHERE id = '$id'";
            $result = $this->db->query($query);

            if ($result && $row = $result->fetch_assoc()) {
                $this->setAttributes($row);
            } else {
                throw new Exception("Round with ID $id not found");
            }
        }
    }

    static public function all($dbConnection) 
    {
        $query = "SELECT * FROM cards";
        $result = $dbConnection->query($query);

        $cards = [];
        if ($result) 
        {
            while ($row = $result->fetch_assoc()) 
            {
                $cards[] = (new self($dbConnection))->setAttributes($row);
            }
        }
        return $cards;
    }

    public function save() {

        $query = "INSERT INTO rounds () VALUES ()";
        $this->db->query($query);

        if ($this->db->affected_rows <= 0) {
            throw new Exception("Failed to create round");
        }

        $this->id = $this->db->insert_id;

        $query = "SELECT * FROM rounds WHERE id = '$this->id'";
        $result = $this->db->query($query);

        if ($result && $row = $result->fetch_assoc()) {
            $this->setAttributes($row);
        }

        return $this;
    }

    public function players() {
        $query = "SELECT * FROM players WHERE match_id = '$this->id'";
        $result = $this->db->query($query);

        $players = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $player = new Player($this->db, $row['id']);
                $players[] = $player;
            }
        }

        return $players;
    }

    public function setAttributes($attributes) {
        foreach ($attributes as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
        return $this;
    }
}
?>
