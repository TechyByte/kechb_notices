<?php
include_once("../../functions/session.php");
$session = new session();
$session->checkSession();
?>
    <h1>Account Management</h1><br />
<?php
echo(($session->group->admin == 1) ? '<a href="password/">Reset A User'."'".'s Password</a><br />' : '<a href="password/">Change My Password</a><br />');
echo(($session->group->admin == 1) ? '<a href="user/">Add User</a><br />' : "");