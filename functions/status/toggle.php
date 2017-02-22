<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
include_once("../../functions/session.php");
$session = new session();
$session->checkSession();
if ($session->user->getUserId() == 1 || $session->user->getUserId() == 2) {
    $file = "status.data";
    $current = file_get_contents($file);
    if ($current == "OK") {
        $new = "BAD";
    } else {
        $new = "OK";
    }
    file_put_contents($file, $new);
    echo("Status changed to: '" . $new . "'");
} else {
    die("Not authorised");
}