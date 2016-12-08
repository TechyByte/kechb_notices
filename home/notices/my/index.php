<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
include_once("../../../functions/session.php");
include_once("../../../header.php");
$session = new session();
$session->checkSession();
$db = new db();
$todayDate = date("Ymd");
$result = $db->queryForRows("SELECT * FROM `notices` WHERE `date` >= " . $todayDate . " AND `user` = '" . $session->user->getUserId() . "' ORDER BY `date` ASC;");
$myNs = $result->num_rows;
?>
<style>
    td {
        vertical-align: top;
    }
</style>
<body class="bg-grayDark">
<div class="grid" style="padding-top:3%;">
    <div class="row cells12">
        <div class="cell bg-grayDarker offset1 colspan8 fg-white">
            <h4 class="tile-area-title small margin20" style="font-size:medium;">You are at KE Camp Hill Intranet / <a href="../../../home/">Dashboard</a> / <a href="../../../home/notices/my/">My Notices</a></h4>
        </div>
        <div class="cell bg-grayDarker colspan2 align-center fg-white">
            <h4 class="tile-area-title small margin20" style="font-size:medium;"<b><a href="../../../home/"><span class="mif-keyboard-return"></span> Return to the Dashboard</a></b></h4>
        </div>
    </div>
    <div class="row cells12">
        <div class="cell bg-white offset1 colspan10">
            <h2 class="margin20">My Notices</h2>

<?php
if ($myNs >= 1) {
?>
<table width="100%" class="margin20">
    <tbody>
    <tr>
        <td style="width:20%;"><b>Date</b></td>
        <td style="width:20%;"><b>Title</b></td>
        <td style="width:45%;"><b>Body</b></td>
        <td style="width:5%;"><b>User</b></td>
        <td style="width:10%;"><b>Actions</b></td>
    </tr>

<?php
while ($row = $result->fetch_assoc()) {
    $nOwner = $db->queryForRow("SELECT * FROM `users` WHERE `id`='".$row["user"]."';");
    echo('<tr><td style="padding-right:5px;">'.date("l jS F Y", strtotime($row["date"])).'</td><td style="padding-right:5px;">'.$row["title"].'</td><td style="padding-right:5px;">'.$row["body"].'</td><td style="padding-right:5px;"><a href= "" style="background-color:#FFFFFF;color:#000000;text-decoration:none" title="' . $nOwner["lastName"] . ', ' . $nOwner["firstName"] . '">'.$nOwner["code"].'</a></td><td style="padding-right:5px;"><a href="../delete/?r=my&id='. $row["id"] .'">Delete</a></td></td></tr>');
}
?>

    </tbody>
</table>
<br />
    <?php } else {
        ?><p class="margin20">You have no notices :-(</p><?php
}
$result = $db->queryForRows("SELECT * FROM `notices` WHERE `date` >= " . $todayDate . " ORDER BY `date` ASC;");
$aNs = $result->num_rows;
?>
            <h2 class="margin20">Other Notices</h2>
            <?php
if ($aNs - $myNs != 0) {
    ?>

<table class="margin20" width="100%">
    <tbody>
    <tr>
        <td style="width:20%;"><b>Date</b></td>
        <td style="width:20%;"><b>Title</b></td>
        <td style="width:45%;"><b>Body</b></td>
        <td style="width:5%;"><b>User</b></td>
        <td style="width:10%;"><b>Actions</b></td>
    </tr>

    <?php
    while ($row = $result->fetch_assoc()) {
        $nOwn = $db->queryForRow("SELECT * FROM `users` WHERE `id`='".$row["user"]."';");
        echo('<tr><td style="padding-right:5px;">'.date("l jS F Y", strtotime($row["date"])).'</td><td style="padding-right:5px;">'.$row["title"].'</td><td style="padding-right:5px;">'.$row["body"].'</td><td style="padding-right:5px;"><a href= "" style="background-color:#FFFFFF;color:#000000;text-decoration:none" title="' . $nOwn["lastName"] . ', ' . $nOwn["firstName"] . '">'.$nOwn["code"].'</a></td>' . (($session->group->getAdmin()==1 || $session->user->getUserCode() == $nOwn["code"]) ? ('<td style="padding-right:5px;"><a href="../delete/?r=my&id='. $row["id"] .'">Delete</a></td>') : ("")) . '</tr>');
    }
    ?>

    </tbody>
</table>
<?php } else { ?>
<p class="margin20">No other notices to show</p>
<?php
}
?>
</div>
        </div>
    </div>
    </body>