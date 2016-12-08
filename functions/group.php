<?php
class group {
    var $groupId;
    var $groupName;
    var $homepage;
    var $admin;

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
}