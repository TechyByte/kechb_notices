<?php
include("mysql.php");
class user {
    var $userFirstName;
    var $userLastName;
    var $userCode;
    var $userGroupId;
    var $userId;
    var $userEmail;
    var $db;

    public function setUser($userId) {
        $this->db = new db();
        $userRec = $this->db->queryForRow("SELECT * FROM `users` WHERE `id`=".$userId);
        $this->setUserFirstName($userRec["firstName"]);
        $this->setUserLastName($userRec["lastName"]);
        $this->setUserCode($userRec["code"]);
        $this->setUserGroupId($userRec["groupId"]);
        $this->setUserId($userId);
        $this->setUserEmail($userRec["email"]);
    }

    /**
     * @return mixed
     */
    public function getUserFirstName() {
        return $this->userFirstName;
    }

    /**
     * @param mixed $userFirstName
     */
    public function setUserFirstName($userFirstName) {
        $this->userFirstName = $userFirstName;
    }

    /**
     * @return mixed
     */
    public function getUserLastName() {
        return $this->userLastName;
    }

    /**
     * @param mixed $userLastName
     */
    public function setUserLastName($userLastName) {
        $this->userLastName = $userLastName;
    }

    /**
     * @return mixed
     */
    public function getUserCode() {
        return $this->userCode;
    }

    /**
     * @param mixed $userCode
     */
    public function setUserCode($userCode) {
        $this->userCode = $userCode;
    }

    /**
     * @return mixed
     */
    public function getUserGroupId() {
        return $this->userGroupId;
    }

    /**
     * @param mixed $userGroupId
     */
    public function setUserGroupId($userGroupId) {
        $this->userGroupId = $userGroupId;
    }

    /**
     * @return mixed
     */
    public function getUserId() {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId) {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getUserEmail() {
        return $this->userEmail;
    }

    /**
     * @param mixed $userEmail
     */
    public function setUserEmail($userEmail) {
        $this->userEmail = $userEmail;
    }
}