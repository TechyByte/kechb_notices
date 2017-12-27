<?php
include_once("../../../functions/session.php");
$session = new session();
$session->checkSession();
?>
<h1>Add Assembly</h1>
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
    <input placeholder="YYYYMMDD" type="text" name="date" value="">
    <small>Enter date with no spaces or symbols in YYYYMMDD.</small>
    <br />
    <input type="submit" name="submit" value="Submit notice">
</form>