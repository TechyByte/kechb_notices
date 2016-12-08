<?php
include_once("../../../functions/session.php");
$session = new session();
$session->checkSession();
?>
<h1>New Assembly</h1>
<p style="color:red">
    <?php
    switch ($_GET["n"]) {
        case "ii":
            echo("Invalid input.");
            break;
        case "una":
            echo("You do not hold sufficient privileges to perform the requested operation.");
            break;
        case "suc":
            echo('<p style="color:green">Success</p>');
            break;
        default:
            continue;
            break;
    }
    ?>
</p>
<form action="process.php" method="post">
    <input placeholder="Notice Title" type="text" name="title" value="">
    <br />
    <textarea placeholder="Notice Text" name="body"></textarea>
    <br />
    <h4>Dates</h4>
        <?php
        $db = new db();
        $todayDate = date("Ymd");
        $result = $db->queryForRows("SELECT * FROM `assemblies` WHERE `date` >= " . $todayDate . " ORDER BY `date` ASC LIMIT 8;");
        $first = true;
        while ($row = $result->fetch_assoc()) {
            if ($first) {
                $first = false;
                echo('<input type="checkbox" name="dates[]" value="' . $row["id"] . '" checked="checked">' . (($row["date"] == $todayDate) ? "<b>(Today)</b> " : "" ) . date("l jS F Y", strtotime($row["date"])) . '<br />');
            } else {
                echo('<input type="checkbox" name="dates[]" value="' . $row["id"] . '">' . date("l jS F Y", strtotime($row["date"])) . '<br />');
            }
        }
        ?>
    <br />
    <input type="submit" name="submit" value="Submit notice">
</form>