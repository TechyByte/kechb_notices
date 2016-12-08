<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link rel='shortcut icon' type='image/x-icon' href='favicon.ico' />

    <title>KE Camp Hill Intranet: Login</title>

    <link href="../css/metro.css" rel="stylesheet">
    <link href="../css/metro-icons.css" rel="stylesheet">
    <link href="../css/metro-responsive.css" rel="stylesheet">

    <script src="../js/jquery-2.1.3.min.js"></script>
    <script src="../js/metro.js"></script>

    <style>
        .login-form {
            width: 25rem;
            height: 17.75rem;
            position: fixed;
            top: 50%;
            margin-top: -9.375rem;
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
<?php
$type = "info";
$title = "Unknown Error";
$body = "Please try again or contact the Technical Team for assistance.";
switch ($_GET["n"]) {
    case "nu";
        $title = "Missing information.";
        $body = "No username given. Please try again.";
        $type = "warning";
        break;
    case "np";
        $title = "Missing information.";
        $body = "No password given. Please try again.";
        $type = "warning";
        break;
    case "nx":
        $title = "No user found.";
        $body = "No user found by that name. Please double check your username.";
        $type = "warning";
        break;
    case "ic":
        $title = "Bad information provided.";
        $body = "Incorrect password specified. Please try again.";
        $type = "alert";
        break;
    case "sexp":
        $title = "Session timeout.";
        $body = "Your session has timed out. Please login again.";
        $type = "info";
        break;
    default:
        break;

}
if (isset($_GET["n"])) {
echo('<div data-role="dialog" data-place="top-center" data-type="' . $type . '" data-hide="5000" id="dialog"><div class="container padding20">
            <h1>' .  $title . '</h1>
            <p>' . $body . '</p>
        </div></div>');
    echo('<script>var dialog = $("#dialog").data("dialog");dialog.open();</script>');
}
?>
</head>
<body class="bg-darkTeal">
<div class="login-form padding20 block-shadow">
    <form action="process.php" method="post">
        <h1 class="text-light">KE Camp Hill Intranet</h1>
        <hr class="thin"/>
        <p style="color:orangered" class="text-light">This is a secure site. Do not share your password.</p>
        <div class="input-control text full-size" data-role="input">
            <!--<label for="user_login">Username: </label>-->
            <input placeholder="Username" type="text" name="code" id="user_login" value="">
            <button class="button helper-button clear"><span class="mif-cross"></span></button>
        </div>
        <br />
        <div class="input-control password full-size" data-role="input">
            <!--<label for="user_password">Password: </label>-->
            <input placeholder="Password" type="password" id="user_password" name="password" value="">
            <button class="button helper-button reveal"><span class="mif-looks"></span></button>
        </div>
        <br />
        <div class="form-actions">
            <button type="submit" class="button primary">Login</button>
            <!--<button type="button" class="button link">Cancel</button>-->
        </div>
    </form>
</div>
</body>
</html>