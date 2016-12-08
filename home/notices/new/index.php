<?php
include_once("../../../functions/session.php");
include_once("../../../header.php");
$session = new session();
$session->checkSession();
?>
<body class="bg-grayDark">
    <div class="grid" style="padding-top:10%;">
        <div class="row cells3">
            <div class="cell bg-white offset1 padding20">
                <h1>Create a New Notice</h1>
                <form action="process.php" method="post">
                    <div class="input-control text">
                        <b>Title</b>
                        <input placeholder="Notice Title" class="margin5" type="text" name="title" value="">
                    </div>
                    <br />
                    <br />
                    <div class="input-control textarea">
                        <b>Contents</b>
                        <textarea style="height:150px;" placeholder="Notice Text" class="widgEditor nothing margin5" name="body"></textarea>
                    </div>
                    <br />
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
                            echo('<label class="input-control checkbox small-check"><input type="checkbox" name="dates[]" value="' . $row["id"] . '" checked="checked"><span class="check"></span><span class="caption">' . (($row["date"] == $todayDate) ? "<b>(Today)</b> " : "" ) . date("l jS F Y", strtotime($row["date"])) . '</span></label><br />');
                        } else {
                            echo('<label class="input-control checkbox small-check"><input type="checkbox" name="dates[]" value="' . $row["id"] . '"><span class="check"></span><span class="caption">' . date("l jS F Y", strtotime($row["date"])) . '</span></label><br />');
                        }
                    }
                    ?>
                    <br />
                    <input type="submit" name="submit" value="Submit notice">
                    <p style="color:red">
                        <?php
                        if (isset($_GET["n"])) {
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
                        }
                        ?>
                    </p>
                </form>
            </div>
        </div>
    </div>
    <style type="text/css" media="all">
        @import "../../../css/info.css";
        @import "../../../css/main.css";
        @import "../../../css/widgEditor.css";
    </style>

    <script type="text/javascript" src="../../../js/widgEditor.js"></script>
</body>