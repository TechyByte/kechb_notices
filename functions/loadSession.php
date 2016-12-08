<?php
include_once("session.php");
$session = new session();
function redirect($url, $permanent = false) { header('Location: ' . ((((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . "/" . $url), true, $permanent ? 301 : 302); exit(); }
function redirLogin($arg="") { redirect("login/".$arg); }
function redirHome() { redirect("home/"); }
$session->checkSession();