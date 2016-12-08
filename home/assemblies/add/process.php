<?php

include_once("../../../functions/notice.php");
function redirect($url, $permanent = false) { header('Location: ' . ((((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . "/" . $url), true, $permanent ? 301 : 302); exit(); }
$db = new db();
if (isset($_POST["title"]) && isset($_POST["body"]) && isset($_POST["dates"])) {
    $notice = new notice();
    foreach($_POST['dates'] as $date=>$entry) {
        $notice->newNotice($_POST["title"], $_POST["body"], $entry);
    }
    redirect("home/notices/new/?n=suc"); //SUCCESS notice
} else {
    redirect("home/notices/new/?n=ii"); //INVALID INOUT notice
    exit();
}