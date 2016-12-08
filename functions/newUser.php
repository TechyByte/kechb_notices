<?php

include_once("mysql.php");

$db = new db();
if (isset($_POST["fname"]) && isset($_POST["lname"]) && isset($_POST["code"]) && isset($_POST["password"]) && isset($_POST["email"]) && isset($_POST["groupId"])) {
    $idLookup = $db->queryForRow("SELECT MAX(id) FROM `users`;");
    $newUserId = $idLookup["MAX(id)"] + 1;
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $db->queryForNothing("INSERT INTO `users` (`id`, `firstName`, `lastName`, `code`, `groupId`, `password`, `email`) VALUES ('" . $newUserId . "', '" . $_POST["fname"] . "', '" . $_POST["lname"] . "', '" . strtoupper(["code"]) . "', '" . $_POST["groupId"] . "', '" . $password . "', '" . $_POST["email"] . "');");
    echo("User created successfully.");
} else {
    die("Insufficient data sent.");
}
