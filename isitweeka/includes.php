<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
require("../functions/mysql.php");

/* --==[CODES]==--
a = Week A
b = Week B
wa = Weekend but next week is Week A
wb = Weekend but next week is Week B
x = Error
*/

class week {
    var $code = "X";
    var $date = "20001215";
    var $message = "Happy Birthday!";

    public function initialise() {
        $this->setDate(date("Ymd"));
        $db = new db;
        $day = $db->queryForRow("SELECT * FROM `weeks` WHERE `date` = '" . $this->getDate() . "'");
        if(!isset($day["code"])) {
            $this->setMessage("Error 0x0000");
        } else {
            $this->setCode($day["code"]);
            $this->setMessage($day["message"]);
        }
    }
    private function setCode($code) { $this->code = strtoupper($code); }
    private function setDate($date) { $this->date = $date; }
    private function setMessage($message) { $this->message = $message; }
    public function getCode() { return $this->code; }
    public function getDate() { return $this->date; }
    public function getMessage() { return $this->message; }
}

