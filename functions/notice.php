<?php

include_once("session.php");

class notice {
    var $id;
    var $title;
    var $body;
    var $user;
    var $date;

    public function fetchNotice($id) {
        $db = new db();
        $rec = $db->queryForRow("SELECT * FROM `notices` WHERE `id`='" . $id . "';");
        $this->setId($id);
        $this->setTitle($rec["title"]);
        $this->setBody($rec["body"]);
        $this->setDate($rec["date"]);
        $this->setUser($rec["user"]);
    }

    private function date2id($date) {
        $db = new db();
        $res = $db->queryForRow("SELECT * FROM `assemblies` WHERE `date` = '" . $date . "';");
        return $res["id"];
    }

    public function newNotice($title, $body, $assemblyId) {
        $this->setTitle($title);
        $this->setBody($body);
        $db = new db(); //Initialise database object for creating new session
        $assRec = $db->queryForRow("SELECT * FROM `assemblies` WHERE id='" . $assemblyId . "';");
        $this->setDate($assRec["date"]);
        $session = new session();
        $session->checkSession();
        $this->setUser($session->user->getUserId());
        $idLookup = $db->queryForRow("SELECT MAX(id) FROM `notices`;"); //Lookup most recent session
        $newNoticeId = $idLookup["MAX(id)"] + 1; //Increment highest current session value by 1
        $db->queryForNothing("INSERT INTO `notices` (`id`, `title`, `body`, `user`, `date`) VALUES ('" . $newNoticeId . "', '" . $this->getTitle() . "', '" . $this->getBody() . "', '" . strtoupper($this->getUser()) . "', '" . $this->getDate() . "');"); //Insert new session data in to table
    }

    public function updateNotice($id, $field, $value) {
        $this->fetchNotice($id);
        $this->deleteNotice($this->getId());
        switch ($field) {
            case "title":
                $this->newNotice($value, $this->getBody(), $this->date2id($this->getDate()));
                break;
            case "body";
                $this->newNotice($this->getTitle(), $value, $this->date2id($this->getDate()));
                break;
            case "date":
                $this->newNotice($this->getTitle(), $this->getBody(), $value);
                break;
            default:
                break;
        }
    }

    public function deleteNotice($id) {
        $this->fetchNotice($id);
        $delDb = new db();
        $delDb->queryForNothing("DELETE FROM `notices` WHERE `notices`.`id` =  '" . $this->getId() . "'");
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

}