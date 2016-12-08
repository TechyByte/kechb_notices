<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
include_once("session.php");
$session = new session();
$session->checkSession();
var_dump($session);