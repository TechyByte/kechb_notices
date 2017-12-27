<?php

include_once("../functions/mysql.php");
$messageDb = new db();

$messageResult = $messageDb->queryForRows("SELECT * FROM `thisday` WHERE `date` = " . date("Ymd") . ";");

if ($messageResult->num_rows > 0) {
    while ($row = $messageResult->fetch_assoc()) {
        echo($row["message"]);
    }
} else {
    echo(file_get_contents('http://numbersapi.com/'.$_GET["m"].'/'.$_GET["d"].'/date'));
}