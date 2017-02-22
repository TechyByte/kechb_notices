<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
include_once("session.php");
echo ($_SERVER['REMOTE_ADDR']);
echo ('INSERT INTO `sessions` (`id`, `expiry`, `userId`, `ip`) VALUES (\'' . "1" . '\', \'' . "1" . '\', \'' . "1" . '\', ' . $_SERVER["REMOTE_ADDR"] . ');');


