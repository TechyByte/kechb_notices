<?php
include_once("../../functions/session.php");
$session = new session();
$session->checkSession();
?>
    <h1>Notices Dashboard</h1><br />
<?php
echo('<a href="new/">Add Notice</a><br />');
echo(($session->group->admin == 1) ? '<a href="my/">Staff Notices</a><br />' : '<a href="my/">My Notices</a><br />');
echo(($session->group->admin == 1) ? '<a href="view/">View Notices</a><br />' : '');