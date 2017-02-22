<?php
/**
 * Created by PhpStorm.
 * User: george
 * Date: 1/30/17
 * Time: 5:35 PM
 */
include_once("../../../functions/notice.php");
include_once("../../../functions/mysql.php");

class api {
    var $color = "000000";
    var $title = "Error";
    var $body = "Unknown Error";
    var $id = 2;
    var $todayIds;

    var $currentOn;
    var $nextOn;
    var $error = 0;
    var $db;

    public function first() {
        $firstOn = $this->getFirstOnId();
        if ($firstOn != "0") {
            $this->setNextOn($firstOn);
        } else {
            $this->setId(0);
            $this->setTitle("No Notices");
            $this->setBody("<h4>No Notices Available Now</h4><p>This is likely because today is not listed as having an assembly.</p>");
            $this->setColor();
        }
    }

    public function next($id) {
        $this->setCurrentOn($id);
        $this->setNextOn($this->getNextOnId());
    }

    private function getError() {
        return $this->error;
    }

    private function loadTodayIds() {
        $this->db = new db();
        $result = $this->db->queryForRows("SELECT * FROM `notices` WHERE date = '" . date("Ymd") . "';");
        $todayIds = array();
        while ($row = $result->fetch_assoc()) {
            $todayIds[] = $row["id"];
        }
        sort($todayIds);
        $this->setTodayIds($todayIds);
    }

    private function getFirstOnId() {
        $this->loadTodayIds();
        if (count($this->getTodayIds()) > 0) {
            return $this->getTodayIds()[0];
        } else {
            return "0";
        }
    }

    private function getNextOnId() {
        $this->loadTodayIds();
        $position = array_search($this->currentOn->getId(), $this->getTodayIds());
        $countNotices = count($this->getTodayIds());
        if (($position + 1) == $countNotices) {
            return $this->getFirstOnId();
        } else {
            return $this->getTodayIds()[$position+1];
        }
    }

    public function setError(int $error) {
        $this->error = $error;
    }

    public function setDb($db) {
        $this->db = $db;
    }

    public function getTodayIds() {
        return $this->todayIds;
    }

    public function setTodayIds($todayIds) {
        $this->todayIds = $todayIds;
    }

    private function setNextOn($nextOn) {
        $this->nextOn = new notice();
        $this->nextOn->fetchNotice($nextOn);
        $this->setId($nextOn);
        $this->setTitle($this->nextOn->getTitle());
        $this->setBody($this->nextOn->getBody());
        $this->setColor();

    }

    public function present() {
        if ($this->getError() == 0) {
            $data = array('id'=>$this->getId(),
                'title'=>$this->getTitle(),
                'body'=>$this->getBody(),
                'color'=>$this->getColor(),
                'error_code'=>$this->getError());
        } else {
            $data = array('id'=>$this->getId(),
                'title'=>$this->getTitle(),
                'body'=>$this->getBody(),
                'color'=>$this->getColor(),
                'error_code'=>$this->getError(),
                'error_message'=>$this->errorCodeToMessage($this->getError()));
        }
        echo(json_encode($data));
    }

    private function errorCodeToMessage(int $code) {
        $errors = array(
            1=>"Unknown Action (Data Provided)",
            2=>"Unknown Action (No Data Provided)",
            3=>"No Action Specified"
        );
        return $errors[$code];
    }

    private function setCurrentOn($currentOn) {
        $this->currentOn = new notice();
        $this->currentOn->fetchNotice($currentOn);
    }

    private function getBody() {
        return $this->body;
    }

    private function getId() {
        return $this->id;
    }

    private function setId($id) {
        $this->id = $id;
    }

    private function setBody($body) {
        $this->body = $body;
    }

    private function getColor() {
        return $this->color;
    }

    private function setColor() {
        $colors = array("8E4A1A",
            "5C0909",
            "5C3B0A",
            "3B5C0A",
            "0A5B37",
            "0B4D5B",
            "19214D",
            "3F0D59",
            "5A0B27",
            "077816",
            "087768",
            "0051A8",
            "0A5B37",
            "0B4D5B",
            "077816",
            "087768");
        switch ($this->getTitle()) {
            case "Technical Team":
                $color = "000000";
                break;
            case "No Notices":
                $color = "222222";
                break;
            default:
                $color = $colors[hexdec(md5($this->getTitle())[hexdec(md5($this->getTitle())[0])])];
        }
        $this->color = $color;
    }

    private function getTitle() {
        return $this->title;
    }

    private function setTitle($title) {
        $this->title = $title;
    }
}

$api = new api();

if (isset($_GET["action"])) {
    if (isset($_GET["data"])) {
        switch ($_GET["action"]) {
            case "next":
                $api->next($_GET["data"]);
                break;
            default:
                $api->setError(1);
                break;
        }
    } else {
        switch ($_GET["action"]) {
            case "first":
                $api->first();
                break;
            default:
                $api->setError(2);
                break;
        }
    }
} else {
    $api->setError(3);
}

$api->present();