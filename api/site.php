<?php
/**
 * Created by PhpStorm.
 * User: george
 * Date: 5/31/17
 * Time: 6:11 PM
 */

/* $array = array("ncn"=>$_GET["ncn"], "name"=>"Unknown site");

switch ($array["ncn"]) {
    case "20149":
        $array["name"] = "King Edward VI Camp Hill School for Boys";
        break;
    case "20153":
        $array["name"] = "King Edward VI Five Ways";
        break;
    case "20151":
        $array["name"] = "King Edward VI Camp Hill School for Boys";
        break;
    default:
        break;
}

echo(json_encode($array)); */

require_once("../functions/mysql.php");
$db = new db();
if(!empty($_POST["id"])) {
    $query ="SELECT * FROM `sites` WHERE id like '" . $_POST["id"] . "%' OR `name` like '" . $_POST["id"] . "%' ORDER BY id LIMIT 0,6";
    $result = $db->queryForRows($query);
    while($row=mysqli_fetch_assoc($result)) {
        $resultset[] = $row;
    }

    if(!empty($resultset)) {
        ?>
        <ul id="site-list">
            <?php
            foreach($resultset as $item) {
                ?>
                <li onClick="selectSite('<?php echo $item["id"]; ?>');"><?php echo $item["id"]." - ".$item["name"]; ?></li>
            <?php } ?>
        </ul>
    <?php }
} ?>