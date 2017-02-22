<?php
class group {
    var $groupId;
    var $groupName;
    var $homepage;
    var $admin;

    public function setGroup($groupId) {
        $this->db = new db();
        $groupRec = $this->db->queryForRow("SELECT * FROM `groups` WHERE `id`=".$groupId);
        $this->setGroupId($groupId);
        $this->setGroupName($groupRec["name"]);
        $this->setHomepage($groupRec["homepage"]);
        $this->setAdmin($groupRec["admin"]);
    }

    public function setGroupId($groupId) {
        $this->groupId = $groupId;
    }

    public function setGroupName($groupName) {
        $this->groupName = $groupName;
    }

    public function setHomepage($homepage) {
        $this->homepage = $homepage;
    }

    public function setAdmin($admin) {
        $this->admin = $admin;
    }

    /**
     * @return mixed
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * @return mixed
     */
    public function getHomepage()
    {
        return $this->homepage;
    }

    /**
     * @return mixed
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * @return mixed
     */
    public function getGroupName()
    {
        return $this->groupName;
    }
}