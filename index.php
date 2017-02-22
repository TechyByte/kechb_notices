<?php
include_once("functions/session.php");
$session = new session;
$session->checkSession();
//header('Location: ' . ((((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . "/home"), true, 302);
header(("Location: https://notices.techybyte.co.uk/home"), true, 302);
exit();