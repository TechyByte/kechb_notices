<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
include_once("../../../functions/session.php");
$session = new session();
$session->checkSession();
$session->signOut();
header('Location: ' . ((((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . "/login/"), true, false ? 301 : 302);
exit();