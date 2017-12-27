
<?php
include_once("../../../functions/session.php");
$session = new session();
$session->checkSession();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link rel='shortcut icon' type='image/x-icon' href='../../../favicon.ico' />

    <title>KE Camp Hill Intranet: Add assemmbly</title>

    <link href="../../../css/metro.css" rel="stylesheet">
    <link href="../../../css/metro-icons.css" rel="stylesheet">
    <link href="../../../css/metro-responsive.css" rel="stylesheet">

    <script src="../../../js/jquery-2.1.3.min.js"></script>
    <script src="../../../js/metro.js"></script>

    <style>
        .login-form {
            width: 25rem;
            height: 23.75rem;
            position: fixed;
            top: 50%;
            margin-top: -11.375rem;
            left: 50%;
            margin-left: -12.5rem;
            background-color: #ffffff;
            opacity: 0;
            -webkit-transform: scale(.8);
            transform: scale(.8);
        }
    </style>

    <script>
        $(function(){
            var form = $(".login-form");

            form.css({
                opacity: 1,
                "-webkit-transform": "scale(1)",
                "transform": "scale(1)",
                "-webkit-transition": ".5s",
                "transition": ".5s"
            });
        });
    </script>
</head>
<body class="bg-darkTeal">

<?php
$type = "info";
$title = "Unknown Error";
$body = "Please try again or contact the Technical Team for assistance.";
if (isset($_GET["n"])) {
    switch ($_GET["n"]) {
        case "li";
            $title = "Invalid submission.";
            $body = "Date was not in suitable formal. Please try again.";
            $type = "warning";
            break;
        case "una":
            $title = "Unauthorised.";
            $body = "You do not hold sufficient privileges to perform the requested operation.";
            $type = "warning";
            break;
        case "suc":
            $title = "Success.";
            $body = "Assembly added successfully.";
            $type = "success";
            break;
        default:
            break;

    }
    echo('<div data-place="top-center" data-role="dialog" data-type="' . $type . '" data-hide="5000" id="dialog"><div class="container padding20">
            <h1>' .  $title . '</h1>
            <p>' . $body . '</p>
        </div></div>');

    echo('<script>var dialog = $("#dialog").data("dialog");dialog.open();</script>');
}
?>

<div class="login-form padding20 block-shadow">
    <form action="process.php" method="post">
        <h1 class="text-light">KE Camp Hill Intranet</h1>
        <h3 class="text-light">Add assembly</h3>
        <hr class="thin"/>
        <div class="input-control text full-size" data-role="input">
            <!--<label for="user_login">Username: </label>-->
            <input placeholder="YYYYMMDD" type="text" name="date" id="name" value="">
            <button class="button helper-button clear"><span class="mif-cross"></span></button>
        </div>
        <small>Enter assembly date with no spaces or symbols in YYYYMMDD format.</small>
        <br />
        <div class="form-actions">
            <button type="submit" name="submit" class="button primary">Change Password</button>
            <!--<button type="button" class="button link">Cancel</button>-->
        </div>
    </form>
    <h4 class="tile-area-title small margin5" style="font-size:medium;"<b><a href="../../../home/"><span class="mif-keyboard-return"></span> Return to the Dashboard</a></b></h4>
</div>
</body>
</html>