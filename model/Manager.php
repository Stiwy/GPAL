<?php

class Manager
{
    public function dbConnect()
    {
        try
        {
            $db = new PDO('mysql:host=95.128.74.44;dbname=robem_medical;charset=utf8', 'stiwy', '45uyL36U712',  array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        catch(Exception $e)
        {
                die('Erreur : '.$e->getMessage());
        }

        return $db;
    }

    protected function pdoSelect($from, $where, $orderBy, $value) {
        
        $req = $this->dbConnect()->prepare("SELECT * FROM $from WHERE $where ORDER BY $orderBy LIMIT 0, 10");
        $req->execute(array($value));
        return $req;
    }

    protected function pdoUpdate($from, $set, $where) {
        $this->dbConnect()->exec("UPDATE $from SET $set WHERE $where");
    }

    protected function pdoDelete($from, $where) {
        $this->dbConnect()->exec("DELETE FROM $from WHERE $where");
    }

    protected function pdoInsert($from, $reference, $weg, $shelf, $quantity) {
        $this->dbConnect()->prepare("INSERT INTO $from(reference, weg, shelf, quantity) VALUES(?, ?, ?, ?)")->execute(array($reference, $weg, $shelf, $quantity));
    }
}   

