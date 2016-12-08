<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
include_once("../../../functions/notice.php");
include_once("../../../functions/session.php");
$session = new session();
$session->checkSession();
function redirect($url, $permanent = false) { header('Location: ' . ((((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . "/" . $url), true, $permanent ? 301 : 302); exit(); }
$db = new db();
if (isset($_GET["id"])) {
    $notice = new notice();
    $notice->fetchNotice($_GET["id"]);
    if ($notice->getUser() == $session->user->getUserId() || $session->group->getAdmin() == 1) {
        $db->queryForNothing("DELETE FROM `notices` WHERE `notices`.`id` = ". $_GET["id"] . ";");
    }
    if($_GET["r"]=="all") {
        redirect("home/notices/view/");
    } else {
        redirect("home/notices/my/");
    }
} else {
    if($_GET["r"]=="all") {
        redirect("home/notices/view/");
    } else {
        redirect("home/notices/my/");
    }
    exit();
}