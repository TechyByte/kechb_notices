<?php
include("includes.php");
include("../info.php");

$week = new week();
$week->initialise();

$response = array(
    "date" => $week->getDate(),
    "code" => $week->getCode(),
    "message" => $week->getMessage(),
    "copyright" => $info->getPrettyCopyright() . " (Version " . $info->getPrettyVersion() . ")");

echo json_encode($response);