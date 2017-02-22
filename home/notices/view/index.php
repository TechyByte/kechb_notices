<?php
include_once("../../../functions/session.php");
ini_set('display_errors',1);
error_reporting(E_ALL);
$session = new session();
$session->checkSession();
$db = new db();
$todayDate = date("Ymd");
$result = $db->queryForRows("SELECT * FROM `notices` WHERE `date` " . (isset($_GET["today"]) ? "= " : ">= ") . $todayDate . " ORDER BY `date` ASC;");
$first = true;
?>
<table width="100%">
    <tbody>
    <tr>
        <td><b>Date</b></td>
        <td><b>Title</b></td>
        <td><b>Body</b></td>
        <td><b>User</b></td>
        <td><b>Actions</b></td>
    </tr>

    <?php
    while ($row = $result->fetch_assoc()) {
        echo('<tr><td>'.date("l jS F Y", strtotime($row["date"])).'</td><td>'.$row["title"].' #'.$row["id"].'</td><td>'.$row["body"].'</td><td>'.$db->queryForRow("SELECT * FROM `users` WHERE `id`='".$row["user"]."';")["code"].'</td><td><a href="../delete/?r=all&id='. $row["id"] .'">Delete</a></td></td></tr>');
    }
    ?>

    </tbody>
</table>

