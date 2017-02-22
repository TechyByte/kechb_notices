<?php
include_once("../functions/session.php");

function redirect($url, $permanent = false) { header('Location: ' . ("https://notices.techybyte.co.uk/" . $url), true, $permanent ? 301 : 302); exit(); }

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
$usrPassword = "";
$usrId = "1234567890";

$db->setDbObj();
$pps = $db->obj->prepare("SELECT id, password FROM `users` WHERE `code`=?");
$pps->bind_param('s', $code);
$pps->execute();
$pps->bind_result($usrId, $usrPassword);
$pps->fetch();

if ($usrId == "1234567890") {
    redirect("login/?n=nx"); //NON-EXISTENT USER notice
    exit();
}

if (!(password_verify($_POST["password"], $usrPassword))) {
    redirect("login/?n=ic"); //INCORRECT PASSWORD notice
    exit();
}

$session = new session();
$session->newSession($usrId);

$pps->close();

if ($_POST["password"]=="password") {
    redirect("home/account/password?n=1t");
} else {
    redirect("home/");
}

