<?php

include_once("../../../functions/loadSession.php");

$db = new db();
if (isset($_POST["fname"]) && isset($_POST["lname"]) && isset($_POST["code"]) && isset($_POST["password"]) && isset($_POST["email"]) && isset($_POST["groupId"])) {
    if ($session->group->admin != 1) {
        redirect("home/account/user/?n=una"); //UNAUTH notice
        exit();
    }
    $idLookup = $db->queryForRow("SELECT MAX(id) FROM `users`;");
    $newUserId = $idLookup["MAX(id)"] + 1;
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $db->queryForNothing("INSERT INTO `users` (`id`, `firstName`, `lastName`, `code`, `groupId`, `password`, `email`) VALUES ('" . $newUserId . "', '" . $_POST["fname"] . "', '" . $_POST["lname"] . "', '" . strtoupper($_POST["code"]) . "', '" . $_POST["groupId"] . "', '" . $password . "', '" . $_POST["email"] . "');");
    redirect("home/account/user/?n=suc"); //SUCCESS notice
} else {
    redirect("home/account/user/?n=iu"); //INVALID USER notice
    exit();
}