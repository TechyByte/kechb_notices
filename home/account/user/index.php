<h1>Add User</h1>
<p style="color:red">
    <?php
    include_once("../../../functions/session.php");
    $session = new session();
    $session->checkSession();
    if (isset($_GET["n"])) {
        switch ($_GET["n"]) {
            case "iu":
                echo("Invalid user details provided.");
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
    }
    ?>
</p>
<form action="process.php" method="post">
    <input placeholder="First Name" type="text" name="fname" value="">
    <br />
    <input placeholder="Last Name" type="text" name="lname" value="">
    <br />
    <input placeholder="Code/username" type="text" name="code" value="">
    <br />
    <input placeholder="Email" type="text" name="email" value="">
    <br />
    <select name="groupId" title="Groups">
        <option value="1" selected>Admin</option>
        <option value="2">Staff</option>
    </select>
    <br />
    <input placeholder="Password" type="text" name="password" value="password">
    <br />
    <input type="submit" name="submit" value="Submit account">
</form>