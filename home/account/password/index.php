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

    <title>KE Camp Hill Intranet: Change Password</title>

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
    case "nu";
        $title = "Missing information.";
        $body = "No username given. Please try again.";
        $type = "warning";
        break;
    case "np";
        $title = "Missing information.";
        $body = "No new password given. Please try again.";
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
    case "no";
        $title = "Missing information.";
        $body = "No old password provided. Please try again.";
        $type = "warning";
        break;
    case "nm":
        $title = "Bad information provided.";
        $body = "Passwords did not match. Please try again.";
        $type = "alert";
        break;
    case "iu":
        $title = "Invalid user.";
        $body = "Invalid user specified. Please try again.";
        $type = "alert";
    case "una":
        $title = "Unauthorised.";
        $body = "You do not hold sufficient privileges to perform the requested operation.";
        $type = "warning";
        break;
    case "1t":
        $title = "Welcome!";
        $body = "Because this is your first time logging in or your password has been reset, please enter a new password.";
        $type = "info";
        break;
    case "ins":
        $title = "Security error.";
        $body = "The provided password does not meet the security requirements. Password must be 6 or more characters with a letter and a number.";
        $type = "warning";
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
        <h3 class="text-light">Change Password</h3>
        <hr class="thin"/>
        <div class="input-control text full-size" data-role="input">
            <!--<label for="user_login">Username: </label>-->
            <input placeholder="User" type="text" name="username" id="user_login" value="<?php echo($session->user->getUserCode()); ?>">
            <button class="button helper-button clear"><span class="mif-cross"></span></button>
        </div>
        <br />
        <div class="input-control password full-size" data-role="input">
            <!--<label for="user_password">Password: </label>-->
            <input placeholder="Old password" type="password" id="user_password" name="oldpassword" value="">
            <button class="button helper-button reveal"><span class="mif-looks"></span></button>
        </div>
        <div class="input-control password full-size" data-role="input">
            <!--<label for="user_password">Password: </label>-->
            <input placeholder="New password" type="password" id="user_password" name="password1" value="">
            <button class="button helper-button reveal"><span class="mif-looks"></span></button>
        </div>
        <div class="input-control password full-size" data-role="input">
            <!--<label for="user_password">Password: </label>-->
            <input placeholder="Confirm new password" type="password" name="password2" value="" id="user_password">
            <button class="button helper-button reveal"><span class="mif-looks"></span></button>
        </div>
        <br />
        <div class="form-actions">
            <button type="submit" class="button primary">Change Password</button>
            <!--<button type="button" class="button link">Cancel</button>-->
        </div>
    </form>
    <h4 class="tile-area-title small margin5" style="font-size:medium;"<b><a href="../../../home/"><span class="mif-keyboard-return"></span> Return to the Dashboard</a></b></h4>
</div>
</body>
</html>