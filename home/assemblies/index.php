<?php
include_once("../../functions/session.php");
$session = new session();
$session->checkSession();
?>
    <h1>Assembly Management</h1><br />
<?php
echo(($session->group->admin == 1) ? '<a href="view/">Manage Assemblies</a><br />' : '<a href="view/">View Assemblies</a><br />');
echo(($session->group->admin == 1) ? '<a href="add/">Add Assembly</a><br />' : "");