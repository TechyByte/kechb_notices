<?php
include_once("../functions/session.php");

function redirect($url, $permanent = false) { header('Location: ' . ((((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . "/" . $url), true, $permanent ? 301 : 302); exit(); }

if (!isset($_POST["code"])) {
    redirect("login/?n=nu"); //NO USERNAME notice
    exit();
}

if (!isset($_POST["password"])) {
    redirect("login/?n=np"); //NO PASSWORD notice
    exit();
}

$db = new db();
$code = strtoupper($_POST["code"]);

$usrRec = $db->queryForRow("SELECT id, password FROM `users` WHERE `code` = '" . $code . "';");

if (count($usrRec) == 0) {
    redirect("login/?n=nx"); //NON-EXISTENT USER notice
    exit();
}

if (!(password_verify($_POST["password"], $usrRec["password"]))) {
    redirect("login/?n=ic"); //INCORRECT PASSWORD notice
    exit();
}

$session = new session();
$session->newSession($usrRec["id"]);

if ($_POST["password"]=="password") {
    redirect("home/account/password?n=1t");
} else {
    redirect("home/");
}


