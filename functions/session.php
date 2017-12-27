<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
include_once("user.php");
include_once("group.php");
include_once("mysql.php");

if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
    $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
}

class session {
    var $sessionId;
    var $sessionExpiry;
    var $user;
    var $group;
    var $db;
    var $ip;

    private function redirect($url, $permanent = false) {
        if ($permanent) {
            header('Location: ' . ("https://".$_SERVER['HTTP_HOST']."/" . $url), true, 302);
        } else {
            header('Location: ' . ("https://".$_SERVER['HTTP_HOST']."/" . $url), true, 302);
        }
        exit(); }

    private function redirectLogin($code) {
        header('Location: ' . ("https://sso-ext.techybyte.co.uk/login?".$code), true, 302);
    }

    private function setCookie($sessionId, $expiry) { setcookie("session", $sessionId, $expiry, "/"); }

    public function checkSession() {
        if (!isset($_COOKIE["session"])) { //If session cookie doesn't exist
            $this->noSession(); //Set current session object to all-zero
            $this->setCookie($_COOKIE["session"], time()-1000);
            $this->redirectLogin("h=t"); //Redirect to login page
        } else { //If session cookie does exist
            $this->fetchSession($_COOKIE["session"]); //Create session object based on session
            if ($this->sessionExpiry <= time()) { //If session expired
                $this->killSession($_COOKIE["session"]);
                $this->setCookie($_COOKIE["session"], time()-1000);
                $this->redirectLogin("n=sexpa"); //Redirect to login, with note that session expired
            }
            if ($this->getIp()!=$_SERVER["REMOTE_ADDR"]) { // If session being used on an alternate host
                $this->killSession($_COOKIE["session"]);
                $this->setCookie($_COOKIE["session"], time()-1000);
                $this->redirectLogin("n=sexpb");
            }
        }
    }

    public function killSession($sessionId) {
        $this->db = new db();
        $this->db->queryForNothing('UPDATE `sessions` SET `expiry` = \'0\' WHERE `sessions`.`id` = ' . $sessionId . ';');
    }

    public function newSession($userId) {
        $newSessionExpiry = time() + 3600; //Reset session expiry time, 60 minutes (60*60 = 3600) from current time

        $this->db = new db(); //Initialise database object for creating new session
        $idLookup = $this->db->queryForRow("SELECT MAX(id) FROM `sessions`;"); //Lookup most recent session
        $newSessionId = $idLookup["MAX(id)"] + 1; //Increment highest current session value by 1
        $this->db->queryForNothing('INSERT INTO `sessions` (`id`, `expiry`, `userId`, `ip`) VALUES (\'' . $newSessionId . '\', \'' . $newSessionExpiry . '\', \'' . $userId . '\', \'' . $_SERVER["REMOTE_ADDR"] . '\');'); //Insert new session data in to table

        //Initialise session object
        $this->selfInit($newSessionId, $newSessionExpiry, $_COOKIE["session"]);

        //Set session cookie
        $this->setCookie($newSessionId, $newSessionExpiry);

        //Initialise contained objects
        $this->setUser($userId);
        $this->setGroup($this->user->getUserGroupId());
    }

    public function fetchSession($sessionId) {
        $this->db = new db();
        $sessionRec = $this->db->queryForRow("SELECT expiry, userId, ip FROM `sessions` WHERE `id`=" . $sessionId . ";");
        if (count($sessionRec) > 0) {
            //Renew session
            $this->db->queryForNothing("UPDATE `sessions` SET `expiry` = '" . (time() + 3600) . "' WHERE `sessions`.`id` = " . $sessionId . ";");

            //Set session cookie
            $this->setCookie($sessionId, (time() + 3600));

            //Initialise session object
            $this->selfInit($sessionId, $sessionRec["expiry"], $sessionRec["ip"]);

            //Initialise contained objects
            $this->setUser($sessionRec["userId"]);
            $this->setGroup($this->user->getUserGroupId());
        } else {
            $this->noSession();
        }
    }

    public function noSession() {
        $this->selfInit(0, 0, "0.0.0.0");
    }

    private function selfInit($sessionId, $sessionExpiry, $sessionIp) {
        $this->setSessionId($sessionId);
        $this->setSessionExpiry($sessionExpiry);
        $this->setIp($sessionIp);
        $this->db = new db();
    }

    private function setSessionId($sessionId) {
        $this->sessionId = $sessionId;
    }

    private function setSessionExpiry($sessionExpiry) {
        $this->sessionExpiry = $sessionExpiry;
    }

    public function signOut() {
        $this->checkSession();
        $this->db->queryForNothing("UPDATE `sessions` SET `expiry` = '" . (1) . "' WHERE `sessions`.`id` = " . $this->sessionId . ";");
        $this->setCookie($this->sessionId, (time()-900));
    }

    private function setUser($userId) {
        $this->user = new user();
        $this->db = new db();
        $userRec = $this->db->queryForRow("SELECT * FROM `users` WHERE `id`=".$userId);
        $this->user->setUserFirstName($userRec["firstName"]);
        $this->user->setUserLastName($userRec["lastName"]);
        $this->user->setUserCode($userRec["code"]);
        $this->user->setUserGroupId($userRec["groupId"]);
        $this->user->setUserId($userId);
        $this->user->setUserEmail($userRec["email"]);
    }

    private function setGroup($groupId) {
        $this->group = new group();
        $this->db = new db();
        $groupRec = $this->db->queryForRow("SELECT * FROM `groups` WHERE `id`=".$groupId);
        $this->group->setGroupId($groupId);
        $this->group->setGroupName($groupRec["name"]);
        $this->group->setHomepage($groupRec["homepage"]);
        $this->group->setAdmin($groupRec["admin"]);
    }

    /**
     * @return mixed
     */
    private function getIp()
    {
        return $this->ip;
    }

    /**
     * @param mixed $ip
     */
    private function setIp($ip)
    {
        $this->ip = $ip;
    }
}