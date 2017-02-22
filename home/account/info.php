<?php
/**
 * Created by PhpStorm.
 * User: george
 * Date: 1/2/17
 * Time: 10:19 PM
 */
include_once("../../functions/user.php");
include_once("../../functions/group.php");
include_once("../../functions/session.php");
ini_set('display_errors',1);
error_reporting(E_ALL);
$session = new session();
$session->checkSession();
$u = new user();
$g = new group();
if (!isset($_GET["u"])) {
    die('No parameters provided. <a href="https://notices.techybyte.co.uk">Return to home</a>');
}
$u->setUser($_GET["u"]);
$g->setGroup($u->getUserGroupId());
echo("<h1>Account details for ".$u->getUserFirstName()." ".$u->getUserLastName()."</h1>");
echo("<p>Username/code: ".$u->getUserCode()."</p>");
echo("<p>Group: #".$u->getUserGroupId()." - ".$g->getGroupName()."</p>");
echo("<p>Administrator rights: ".($g->getAdmin()==1?"Yes":"No")."</p>");
echo("<p>Email: ".$u->getUserEmail()."</p>");