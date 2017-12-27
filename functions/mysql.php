<?php

class db {
    public function connect() {
        $mysqlObj = new mysqli("localhost", "id217864_notices", "vUDg6m4LVyAnq3JG", "id217864_notices");
        //$mysqlObj = new mysqli("aa1aakoygzej97l.cubzqbptcrhl.eu-west-1.rds.amazonaws.com", "u9facwxv7q28", "EdSmAnU9TtbtZfv9", "ebdb");
        if ($mysqlObj->connect_errno) {
            die("Failed to connect to MySQL: " . $mysqlObj->connect_error);
        } else {
            return $mysqlObj;
        }
    }

    var $obj;

    public function setDbObj() {$this->obj=$this->connect();}

    public function queryForRow($query) {
        $row = $this->connect()->query($query)->fetch_array(MYSQLI_BOTH);
        return $row;
    }

    public function queryForRows($query) {
        $rows = $this->connect()->query($query);
        return $rows;
    }

    public function queryForNothing($query) {
        $this->connect()->query($query);
    }
}