<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
class db {
    public function connect() {
        $mysqlObj = new mysqli("localhost", "id217864_notices", "<REDACTED>", "id217864_notices");
        if ($mysqlObj->connect_errno) {
            die("Failed to connect to MySQL: " . $mysqlObj->connect_error);
        } else {
            return $mysqlObj;
        }
    }

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