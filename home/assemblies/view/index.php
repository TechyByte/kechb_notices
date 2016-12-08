<?php
include_once("../../../functions/session.php");
ini_set('display_errors',1);
error_reporting(E_ALL);
$session = new session();
$session->checkSession();
$db = new db();
$todayDate = date("Ymd");
$result = $db->queryForRows("SELECT * FROM `assemblies` WHERE `date` >= " . $todayDate . " ORDER BY `date` ASC;");
$first = true;
?>
<table width="100%">
    <tbody>
    <tr>
        <td><b>Date</b></td>
    </tr>

<?php
while ($row = $result->fetch_assoc()) {
    echo('<tr><td>'.date("l jS F Y", strtotime($row["date"])).'</td></tr>');
}
?>

    </tbody>
</table>
