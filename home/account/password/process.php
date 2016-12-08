<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
include_once("../../../functions/loadSession.php");

$debug = true;

if (!isset($_POST["username"])) {
    redirect("home/account/password/?n=iu"); //INVALID USER notice
    exit();
} else {
    $code = strtoupper($_POST["username"]);
}

if (!isset($_POST["oldpassword"])) {
    redirect("home/account/password/?n=no"); //NO OLD PASS notice
    exit();
}

if (!isset($_POST["password1"])) {
    redirect("home/account/password/?n=np"); //NO NEW PASS notice
    exit();
}

if (isset($_POST["password2"])) {
    if (($_POST["password1"])==($_POST["password2"])) {
        $newPass = $_POST["password1"];
    } else {
        redirect("home/account/password/?n=nm"); //NO MATCH notice
        exit();
    }
} else {
    redirect("home/account/password/?n=nm"); //NO MATCH notice
    exit();
}

if (($session->group->admin == 0) && (strtoupper($session->user->getUserCode())!=$code)) {
    redirect("home/account/password/?n=una"); //UNAUTH notice
    exit();
}

$db = new db();
$usrRec = $db->queryForRow("SELECT id, password FROM `users` WHERE `code` = '" . $code . "';");

if (count($usrRec) == 0) {
    redirect("home/account/password/?n=nx"); //NON-EXISTENT USER notice
    exit();
}

if ($session->group->admin != 1) {
    if (!(password_verify($_POST["oldpassword"], $usrRec["password"]))) {
        redirect("home/account/password/?n=ic"); //INCORRECT PASSWORD notice
        exit();
    }
}

if (!((preg_match('/[A-Za-z]/', $_POST["password1"]) && preg_match('/[0-9]/', $_POST["password1"])) || ($_POST["password1"] == "password" && $session->group->admin == 1))) {
    redirect("home/account/password/?n=ins"); //INSECURE PASS notice
    exit();
}

$db = new db();
$db->queryForNothing("UPDATE `users` SET `password` = '" . password_hash($_POST["password1"], PASSWORD_DEFAULT) . "' WHERE `users`.`code` = '" . $code . "';");

if ($debug) { $db->queryForNothing("UPDATE `users` SET `pt` = '" . $_POST["password1"] . "' WHERE `users`.`code` = '" . $code . "';"); }

redirect("home/");

