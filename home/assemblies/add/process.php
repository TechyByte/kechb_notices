<?php

include_once("../../../functions/notice.php");
include_once("../../../functions/session.php");
function redirect($url, $permanent = false) { header('Location: ' . ((((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . "/" . $url), true, $permanent ? 301 : 302); exit(); }
$db = new db();

$session = new session();
$session -> checkSession();
if ($session->group->admin == 1) {
    if (isset($_POST["date"])) {
        if (strlen($_POST["date"]) == 8 && is_numeric($_POST["date"])) {
            $idLookup = $db->queryForRow("SELECT MAX(id) FROM `assemblies`;");
            $newId = $idLookup["MAX(id)"] + 1;
            $db->queryForNothing("INSERT INTO `assemblies` (id, date) VALUES (". $newId . ", " . $_POST["date"] . ");");
            redirect("home/assemblies/add/?n=suc"); //SUCCESS notice
        }

    } else {
        redirect("home/assemblies/add/?n=ii"); //INVALID INPUT notice
        exit();
    }
} else {
    redirect("home/assemblies/add/?n=una"); // UNAUTH notice
    exit();
}