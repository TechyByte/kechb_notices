<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
include_once("../functions/loadSession.php");
include_once("../functions/session.php");
$session = new session();
$session->fetchSession($_COOKIE["session"]);
/*echo("Welcome " . $session->user->getUserFirstName() . " " . $session->user->getUserLastName() . " (" . $session->user->getUserCode() . ", " . $session->user->getUserEmail() . ")" . ' <a href="account/signout/">Sign out</a><br />');
echo("<h2>Actions</h2>");
echo('<a href="notices/">Notices</a>');
echo('<a href="assemblies/">Assemblies</a>');
echo('<a href="account/">Account Management</a>');*/
$db = new db();
$todayDate = date("Ymd");
$result = $db->queryForRows("SELECT * FROM `notices` WHERE `date` >= " . $todayDate . " AND `user` = '" . $session->user->getUserId() . "' ORDER BY `date` ASC LIMIT 6;");
$first = true;
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link rel='shortcut icon' type='image/x-icon' href='../favicon.ico' />
    <title>KE Camp Hill Intranet: Dashboard</title>

    <link href="../css/metro.css" rel="stylesheet">
    <link href="../css/metro-icons.css" rel="stylesheet">
    <!--<link href="../css/metro-colors.css" rel="stylesheet">-->
    <!--<link href="../css/metro-responsive.css" rel="stylesheet">-->

    <script src="../js/jquery-2.1.3.min.js"></script>
    <script src="../js/metro.js"></script>

    <style>
        .tile-area-controls {
            position: fixed;
            right: 40px;
            top: 40px;
        }

        .tile-group {
            left: 100px;
        }

        .tile, .tile-small, .tile-sqaure, .tile-wide, .tile-large, .tile-big, .tile-super {
            opacity: 0;
            -webkit-transform: scale(.8);
            transform: scale(.8);
        }

        #charmSettings .button {
            margin: 5px;
        }

        .schemeButtons {
            /*width: 300px;*/
        }

        @media screen and (max-width: 640px) {
            .tile-area {
                overflow-y: scroll;
            }
            .tile-area-controls {
                display: none;
            }
        }

        @media screen and (max-width: 320px) {
            .tile-area {
                overflow-y: scroll;
            }

            .tile-area-controls {
                display: none;
            }

        }
    </style>

    <script>
        (function($) {
            $.StartScreen = function(){
                var plugin = this;
                var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;

                plugin.init = function(){
                    setTilesAreaSize();
                    if (width > 640) addMouseWheel();
                };

                var setTilesAreaSize = function(){
                    var groups = $(".tile-group");
                    var tileAreaWidth = 80;
                    $.each(groups, function(i, t){
                        if (width <= 640) {
                            tileAreaWidth = width;
                        } else {
                            tileAreaWidth += $(t).outerWidth() + 80;
                        }
                    });
                    $(".tile-area").css({
                        width: tileAreaWidth
                    });
                };

                var addMouseWheel = function (){
                    $("body").mousewheel(function(event, delta, deltaX, deltaY){
                        var page = $(document);
                        var scroll_value = delta * 50;
                        page.scrollLeft(page.scrollLeft() - scroll_value);
                        return false;
                    });
                };

                plugin.init();
            }
        })(jQuery);

        $(function(){
            $.StartScreen();

            var tiles = $(".tile, .tile-small, .tile-sqaure, .tile-wide, .tile-large, .tile-big, .tile-super");

            $.each(tiles, function(){
                var tile = $(this);
                setTimeout(function(){
                    tile.css({
                        opacity: 1,
                        "-webkit-transform": "scale(1)",
                        "transform": "scale(1)",
                        "-webkit-transition": ".3s",
                        "transition": ".3s"
                    });
                }, Math.floor(Math.random()*500));
            });

            $(".tile-group").animate({
                left: 0
            });
        });

        function showCharms(id){
            var  charm = $(id).data("charm");
            if (charm.element.data("opened") === true) {
                charm.close();
            } else {
                charm.open();
            }
        }

        function setSearchPlace(el){
            var a = $(el);
            var text = a.text();
            var toggle = a.parents('label').children('.dropdown-toggle');

            toggle.text(text);
        }

        $(function(){
            var current_tile_area_scheme = localStorage.getItem('tile-area-scheme') || "tile-area-scheme-dark";
            $(".tile-area").removeClass (function (index, css) {
                return (css.match (/(^|\s)tile-area-scheme-\S+/g) || []).join(' ');
            }).addClass(current_tile_area_scheme);

            $(".schemeButtons .button").hover(
                function(){
                    var b = $(this);
                    var scheme = "tile-area-scheme-" +  b.data('scheme');
                    $(".tile-area").removeClass (function (index, css) {
                        return (css.match (/(^|\s)tile-area-scheme-\S+/g) || []).join(' ');
                    }).addClass(scheme);
                },
                function(){
                    $(".tile-area").removeClass (function (index, css) {
                        return (css.match (/(^|\s)tile-area-scheme-\S+/g) || []).join(' ');
                    }).addClass(current_tile_area_scheme);
                }
            );

            $(".schemeButtons .button").on("click", function(){
                var b = $(this);
                var scheme = "tile-area-scheme-" +  b.data('scheme');

                $(".tile-area").removeClass (function (index, css) {
                    return (css.match (/(^|\s)tile-area-scheme-\S+/g) || []).join(' ');
                }).addClass(scheme);

                current_tile_area_scheme = scheme;
                localStorage.setItem('tile-area-scheme', scheme);

                showSettings();
            });
        });
    </script>

</head>
<body style="overflow-y: hidden;">
<!--<div data-role="charm" id="charmSearch">
    <h1 class="text-light">Search</h1>
    <hr class="thin"/>
    <br />
    <div class="input-control text full-size">
        <label>
            <span class="dropdown-toggle drop-marker-light">Anywhere</span>
            <ul class="d-menu" data-role="dropdown">
                <li><a onclick="setSearchPlace(this)">Anywhere</a></li>
                <li><a onclick="setSearchPlace(this)">Options</a></li>
                <li><a onclick="setSearchPlace(this)">Files</a></li>
                <li><a onclick="setSearchPlace(this)">Internet</a></li>
            </ul>
        </label>
        <input type="text">
        <button class="button"><span class="mif-search"></span></button>
    </div>
</div>-->

<div data-role="charm" id="charmSettings" data-position="top">
    <h1 class="text-light">Settings</h1>
    <hr class="thin"/>
    <br />
    <div class="schemeButtons">
        <div class="button square-button tile-area-scheme-dark" data-scheme="dark"></div>
        <div class="button square-button tile-area-scheme-darkBrown" data-scheme="darkBrown"></div>
        <div class="button square-button tile-area-scheme-darkCrimson" data-scheme="darkCrimson"></div>
        <div class="button square-button tile-area-scheme-darkViolet" data-scheme="darkViolet"></div>
        <div class="button square-button tile-area-scheme-darkMagenta" data-scheme="darkMagenta"></div>
        <div class="button square-button tile-area-scheme-darkCyan" data-scheme="darkCyan"></div>
        <div class="button square-button tile-area-scheme-darkCobalt" data-scheme="darkCobalt"></div>
        <div class="button square-button tile-area-scheme-darkTeal" data-scheme="darkTeal"></div>
        <div class="button square-button tile-area-scheme-darkEmerald" data-scheme="darkEmerald"></div>
        <div class="button square-button tile-area-scheme-darkGreen" data-scheme="darkGreen"></div>
        <div class="button square-button tile-area-scheme-darkOrange" data-scheme="darkOrange"></div>
        <div class="button square-button tile-area-scheme-darkRed" data-scheme="darkRed"></div>
        <div class="button square-button tile-area-scheme-darkPink" data-scheme="darkPink"></div>
        <div class="button square-button tile-area-scheme-darkIndigo" data-scheme="darkIndigo"></div>
        <div class="button square-button tile-area-scheme-darkBlue" data-scheme="darkBlue"></div>
        <div class="button square-button tile-area-scheme-lightBlue" data-scheme="lightBlue"></div>
        <div class="button square-button tile-area-scheme-lightTeal" data-scheme="lightTeal"></div>
        <div class="button square-button tile-area-scheme-lightOlive" data-scheme="lightOlive"></div>
        <div class="button square-button tile-area-scheme-lightOrange" data-scheme="lightOrange"></div>
        <div class="button square-button tile-area-scheme-lightPink" data-scheme="lightPink"></div>
        <div class="button square-button tile-area-scheme-grayed" data-scheme="grayed"></div>
    </div>
</div>

<div class="tile-area tile-area-scheme-dark fg-white" style="height: 100%; max-height: 100% !important;">
    <h1 class="tile-area-title"><?php
        date_default_timezone_set('Europe/London');

        // 24-hour format of an hour without leading zeros (0 through 23)
        $Hour = date('G');

        if ( $Hour >= 5 && $Hour <= 11 ) {
            echo "Good Morning";
        } else if ( $Hour >= 12 && $Hour <= 18 ) {
            echo "Good Afternoon";
        } else if ( $Hour >= 19 || $Hour <= 4 ) {
            echo "Good Evening";
        }?></h1>
        <h4 class="tile-area-title small" style="font-size:medium;margin-top:65px;">You are at KE Camp Hill Intranet / Dashboard</h4>
    <div class="tile-area-controls">
        <button class="image-button icon-right bg-transparent fg-white bg-grayDark bg-hover-dark no-border"><span class="sub-header no-margin text-light"><?php echo($session->user->getUserFirstName() . " " . $session->user->getUserLastName())?></span> <span class="icon mif-user"></span></button>
        <!--<button class="square-button bg-transparent fg-white bg-grayDark bg-hover-dark no-border" onclick="showCharms('#charmSearch')"><span class="mif-search"></span></button>-->
        <button class="square-button bg-transparent fg-white bg-grayDark bg-hover-dark no-border" onclick="showCharms('#charmSettings')"><span class="mif-cog"></span></button>
        <a href="account/signout/" class="square-button bg-transparent fg-white bg-grayDark bg-hover-dark no-border"><span class="mif-switch"></span></a>
    </div>

    <div class="tile-group double">
        <span class="tile-group-title">Notices</span>

        <div class="tile-container">

            <a href="notices/new/" class="tile-wide bg-indigo fg-white" data-role="tile">
                <div class="tile-content iconic">
                    <span class="icon mif-notification"></span>
                </div>
                <span class="tile-label">New Notice</span>
            </a>

            <!--<div class="tile bg-darkBlue fg-white" data-role="tile" onclick="document.location.href='http://gmail.com'">
                <div class="tile-content iconic">
                    <span class="icon mif-envelop"></span>
                </div>
                <span class="tile-label">Inbox</span>
            </div>-->

            <div class="tile-large bg-steel fg-white" data-role="tile" data-on-click="document.location.href='notices/my/'">
                <div class="tile-content" id="weather_bg" style="background: top left no-repeat; background-size: cover">
                    <div class="padding10">
                        <?php
                        while ($row = $result->fetch_assoc()) {
                            echo('<p class="no-margin text-shadow">'.date("d/m/y", strtotime($row["date"])).': '.$row["title"].' - '.substr($row["body"], 0, 30).'...</p>');
                        }
                        ?>
                    </div>
                </div>
                <span class="tile-label">My Notices</span>
            </div>
        </div>
    </div>
<div class="tile-group double">
        <span class="tile-group-title">Account</span>

        <div class="tile-container">

            <a href="account/password/" class="tile-wide bg-red fg-white" data-role="tile">
                <div class="tile-content iconic">
                    <span class="icon mif-key"></span>
                </div>
                <span class="tile-label">Change Password</span>
            </a>
            <div class="tile bg-red fg-white" data-role="tile" onclick="document.location.href='account/signout'">
                <div class="tile-content iconic">
                    <span class="icon mif-exit"></span>
                </div>
                <span class="tile-label">Sign Out</span>
            </div>
            <?php if ($session->group->getAdmin() == 1) { ?>
            <div class="tile bg-lightGreen fg-white" data-role="tile" onclick="document.location.href='account/user/'">
                <div class="tile-content iconic">
                    <span class="icon mif-user-plus"></span>
                </div>
                <span class="tile-label">Add User</span>
            </div>
            <?php }
            if ($session->group->getAdmin() == 1) { ?>
                <div class="tile-container"><a href="notices/password/" class="tile bg-darkRed fg-white" data-role="tile"><div class="tile-content iconic"><span class="icon mif-database"></span></div><span class="tile-label">Database Management</span></a></div>
            <?php } ?>

                <!--<div class="tile bg-lightGreen fg-white" data-role="tile" data-on-click="document.location.href='account/user/'">
                    <div class="tile-content" id="weather_bg" style="background: top left no-repeat; background-size: cover">
                        <div class="padding10"></div>
                            Content
                        </div>
                    </div>
                    <span class="tile-label">My Notices</span>
                </div>-->
        </div>
    </div>
    <div class="tile-group double"><span class="tile-group-title">Assemblies</span>
        <div class="tile-container">
            <div class="tile-wide bg-lightRed fg-white" data-role="tile" data-on-click="document.location.href='assemblies/view/'">
            <div class="tile-content" id="ass_bg" style="background: top left no-repeat; background-size: cover">
                <div class="padding10">
                    <?php
                    $result = $db->queryForRows("SELECT * FROM `assemblies` WHERE `date` >= " . $todayDate . " ORDER BY `date` ASC LIMIT 4;");
                    while ($row = $result->fetch_assoc()) {
                        echo('<p class="no-margin text-shadow">Assembly: '.date("jS F Y", strtotime($row["date"])).'</p>');
                    }
                    ?>
                </div>
            </div>
            <span class="tile-label">View Assemblies</span>
        </div>
        <?php
if ($session->group->getAdmin() == 1) { ?>
    <div class="tile-container"><a href="account/password/" class="tile bg-lightBlue fg-white" data-role="tile"><div class="tile-content iconic"><span class="icon mif-plus"></span></div><span class="tile-label">Add Assembly</span></a></div>
    <div class="tile-container"><a href="notices/view/" class="tile bg-darkCobalt fg-white" data-role="tile"><div class="tile-content iconic"><span class="icon mif-list"></span></div><span class="tile-label">View All Notices</span></a></div>
    <div class="tile-container"><a href="notices/run/" class="tile bg-lighterBlue fg-white" data-role="tile"><div class="tile-content iconic"><span class="icon mif-film"></span></div><span class="tile-label">Run Notices</span></a></div>
    <!--<div class="tile bg-lightGreen fg-amber" data-role="tile" onclick="document.location.href='."'"."account/user/'".'"><div class="tile-content iconic"><span class="icon mif-users"></span></div><span class="tile-label">Add User</span></div>-->
    <!--<div class="tile bg-lightGreen fg-white" data-role="tile" data-on-click="document.location.href=' . "'account/user/'" . '><div class="tile-content" id="weather_bg" style="background: top left no-repeat; background-size: cover"><div class="padding10">Content</div></div><span class="tile-label">My Notices</span></div>-->


<?php } ?>
        </div>

    <!--<div class="tile-group double">
        <span class="tile-group-title">Images</span>
        <div class="tile-container">
            <div class="tile-wide" data-role="tile" data-effect="slideLeft">
                <div class="tile-content">
                    <a href="http://google.com/search?q=bear" class="live-slide"><img src="../images/1.jpg" data-role="fitImage" data-format="fill"></a>
                    <a href="http://google.com/search?q=cat" class="live-slide"><img src="../images/2.jpg" data-role="fitImage" data-format="fill"></a>
                    <a href="http://google.com/search?q=dog" class="live-slide"><img src="../images/3.jpg" data-role="fitImage" data-format="fill"></a>
                    <a href="http://google.com/search?q=eagle" class="live-slide"><img src="../images/4.jpg" data-role="fitImage" data-format="fill"></a>
                    <a href="http://google.com/search?q=fox" class="live-slide"><img src="../images/5.jpg" data-role="fitImage" data-format="fill"></a>
                </div>
                <div class="tile-label">Gallery</div>
            </div>
            <div class="tile" data-role="tile" data-role="tile" data-effect="slideUpDown">
                <div class="tile-content">
                    <div class="live-slide"><img src="../images/me.jpg" data-role="fitImage" data-format="fill"></div>
                    <div class="live-slide"><img src="../images/spface.jpg" data-role="fitImage" data-format="fill"></div>
                </div>
                <div class="tile-label">Photos</div>
            </div>
            <div class="tile-small bg-amber fg-white" data-role="tile">
                <div class="tile-content iconic">
                    <span class="icon mif-video-camera"></span>
                </div>
            </div>
            <div class="tile-small bg-green fg-white" data-role="tile">
                <div class="tile-content iconic">
                    <span class="icon mif-gamepad"></span>
                </div>
            </div>
            <div class="tile-small bg-pink fg-white" data-role="tile">
                <div class="tile-content iconic">
                    <span class="icon mif-headphones"></span>
                </div>
            </div>
            <div class="tile-small bg-yellow fg-white" data-role="tile">
                <div class="tile-content iconic">
                    <span class="icon mif-lock"></span>
                </div>
            </div>

            <div class="tile-wide bg-orange fg-white" data-role="tile">
                <div class="tile-content image-set">
                    <img src="../images/jeki_chan.jpg">
                    <img src="../images/shvarcenegger.jpg">
                    <img src="../images/vin_d.jpg">
                    <img src="../images/jolie.jpg">
                    <img src="../images/jek_vorobey.jpg">
                </div>
            </div>

        </div>
    </div>

    <div class="tile-group one">
        <span class="tile-group-title">Office</span>

        <div class="tile-small bg-blue" data-role="tile">
            <div class="tile-content iconic">
                <img src="../images/outlook.png" class="icon">
            </div>
        </div>
        <div class="tile-small bg-darkBlue" data-role="tile">
            <div class="tile-content iconic">
                <img src="../images/word.png" class="icon">
            </div>
        </div>
        <div class="tile-small bg-green" data-role="tile">
            <div class="tile-content iconic">
                <img src="../images/excel.png" class="icon">
            </div>
        </div>
        <div class="tile-small bg-red" data-role="tile">
            <div class="tile-content iconic">
                <img src="../images/access.png" class="icon">
            </div>
        </div>
        <div class="tile-small bg-orange" data-role="tile">
            <div class="tile-content iconic">
                <img src="../images/powerpoint.png" class="icon">
            </div>
        </div>
    </div>

    <div class="tile-group double">
        <span class="tile-group-title">Games</span>
        <div class="tile-container">
            <div class="tile" data-role="tile">
                <div class="tile-content">
                    <img src="../images/grid2.jpg" data-role="fitImage" data-format="square">
                </div>
            </div>
            <div class="tile-small" data-role="tile">
                <div class="tile-content">
                    <img src="../images/Battlefield_4_Icon.png" data-role="fitImage" data-format="square">
                </div>
            </div>
            <div class="tile-small" data-role="tile">
                <div class="tile-content">
                    <img src="../images/Crysis-2-icon.png" data-role="fitImage" data-format="square" data-frame-color="bg-steel">
                </div>
            </div>
            <div class="tile-small" data-role="tile">
                <div class="tile-content">
                    <img src="../images/WorldofTanks.png" data-role="fitImage" data-format="square" data-frame-color="bg-dark">
                </div>
            </div>
            <div class="tile-small" data-role="tile">
                <div class="tile-content">
                    <img src="../images/halo.jpg" data-role="fitImage" data-format="square">
                </div>
            </div>
            <div class="tile-wide bg-green fg-white" data-role="tile">
                <div class="tile-content iconic">
                    <img src="../images/x-box.png" class="icon">
                </div>
                <div class="tile-label">X-Box Live</div>
            </div>
        </div>
    </div>

    <div class="tile-group double">
        <span class="tile-group-title">Other</span>
        <div class="tile-container">
            <div class="tile bg-teal fg-white" data-role="tile">
                <div class="tile-content iconic">
                    <span class="icon mif-pencil"></span>
                </div>
                <span class="tile-label">Editor</span>
            </div>
            <div class="tile bg-darkGreen fg-white" data-role="tile">
                <div class="tile-content iconic">
                    <span class="icon mif-shopping-basket"></span>
                </div>
                <span class="tile-label">Store</span>
            </div>
            <div class="tile bg-cyan fg-white" data-role="tile">
                <div class="tile-content iconic">
                    <span class="icon mif-skype"></span>
                </div>
                <div class="tile-label">Skype</div>
            </div>
            <div class="tile bg-darkBlue fg-white" data-role="tile">
                <div class="tile-content iconic">
                    <span class="icon mif-cloud"></span>
                </div>
                <span class="tile-label">OneDrive</span>
            </div>
        </div>
    </div>-->
</div>
</body>
</html>
