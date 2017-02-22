<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
include_once("../../../functions/mysql.php");
$db = new db();
$result = $db->queryForRows("SELECT * FROM `sessions` ORDER BY `id` DESC LIMIT 50;");
$s = $result->num_rows;
include_once("../../../header.php");
?>
<style>
    td {
        vertical-align: top;
    }
</style>
<SCRIPT TYPE="text/javascript"> function popup(mylink, windowname) { if (! window.focus)return true; var href; if (typeof(mylink) == 'string') href=mylink; else href=mylink.href; window.open(href, windowname, 'width=400,height=350,scrollbars=no'); return false; } </SCRIPT>
<body class="bg-grayDark">
<div class="grid" style="padding-top:3%;">
    <div class="row cells12">
        <div class="cell bg-grayDarker offset1 colspan8 fg-white">
            <h4 class="tile-area-title small margin20" style="font-size:medium;">You are at KE Camp Hill Intranet / <a href="../../../home/">Dashboard</a> / Accounts / <a href="#">Sessions</a></h4>
        </div>
        <div class="cell bg-grayDarker colspan2 align-center fg-white">
            <h4 class="tile-area-title small margin20" style="font-size:medium;"<b><a href="../../../home/"><span class="mif-keyboard-return"></span> Return to the Dashboard</a></b></h4>
        </div>
    </div>
    <div class="row cells12">
        <div class="cell bg-white offset1 colspan10">
            <h2 class="margin20">Sessions</h2>
            <?php
            if ($s >= 1) {
                ?>
                <table style="width:97%" class="table striped margin20">
                    <tbody>
                    <tr>
                        <td style="width:20%;"><b>Status</b></td>
                        <td style="width:10%;"><b>User ID</b></td>
                        <td style="width:25%;"><b>User</b></td>
                        <td style="width:35%;"><b>IP</b></td>
                    </tr>

                    <?php
                    while ($row = $result->fetch_assoc()) {
                        $sOwn = $db->queryForRow("SELECT * FROM `users` WHERE `id`='".$row["userId"]."';");
                        switch ($row["expiry"]) {
                            case "0":
                                $status = "Terminated (System)";
                                break;
                            case "1":
                                $status = "Terminated (User)";
                                break;
                            default:
                                if (time()>=$row["expiry"]) {
                                    $status = "Expired on " . date("Y-m-d H:i:s", $row["expiry"]);
                                } else {
                                    $status = "Active until " . date("Y-m-d H:i:s", $row["expiry"]);
                                }
                                break;
                        }
                        $ip = $row["ip"]; // the IP address to query
                        if ($ip != "62.254.202.114") {
                            $query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
                            if ($query && $query['status'] == 'success') {
                                $ip = $ip . "-" . $query["city"] . "/" . $query["region"] . "/" . $query['countryCode'] . "-" . ($query["isp"] == $query["org"] ? $query["isp"] : $query["isp"] . ":" . $query["org"]);
                            }
                        } else {
                            $ip = $ip . "-Birmingham/ENG/GB-Virgin Media";
                        }
                        echo('<tr><td style="padding-right:5px;">'.$status.'</td><td style="padding-right:5px;">'.$row["userId"].'</td><td style="padding-right:5px;"><a onClick="return popup(this, \'User Notes\')" href= "../../account/info.php?u=' . $row["userId"] . '" style="color:#000000;text-decoration:none" title="' . $sOwn["lastName"] . ', ' . $sOwn["firstName"] . '">'.$sOwn["code"] . ": " . $sOwn["lastName"] . ', ' . $sOwn["firstName"].'</a></td><td style="padding-right:5px;">'.$ip.'</td></tr>');
                    }
                    ?>

                    </tbody>
                </table>
            <?php } else {
                ?><p class="margin20">No sessions (?!?!)</p><?php
            }
            ?>
        </div>
    </div>
</div>
</body>