/**
 * Created by george on 1/30/17.
 */

var currentId = 0;
var url = "api.php";
var o = new Date();
var m = "January,February,March,April,May,June,July,August,September,October,November,December".split(",")[o.getMonth()];
var mr = o.getMonth()+1;
var y = o.getFullYear();
var d = o.getDate();

function nth(d) {
    if(d>3 && d<21) return 'th'; // thanks kennebec
    switch (d % 10) {
        case 1:  return "st";
        case 2:  return "nd";
        case 3:  return "rd";
        default: return "th";
    }
}

function update() {
    if (currentId == 0) {
        $.ajax({
            type: 'GET',
            url: url,
            data: { action: "first" },
            dataType: 'json',
            success: function (data) {
                currentId = data["id"];
                var nextColor = data["color"];
                $("#notice-container").fadeOut();
                $("body").css({ backgroundColor: "#"+nextColor});
                setTimeout(function() {
                    $("#body-js-cont").html('<div id="body" style="height:740px;width:1200px;" class="body container">'+data['body']+'</div>');
                    $("#title-js-cont").html('<div id="title" style="height:180px;width:1200px;" class="title container">'+data['title']+'</div>');
                    $("#notice-container").fadeIn();
                }, 390);
                setTimeout(function() {
                    $('#title').boxfit({maximum_font_size: 112, align_center: false});
                    $('#body').boxfit({multiline: true, maximum_font_size: 84, align_middle: false, align_center: false});
                }, 400)
                setTimeout(function() {
                    $('#title').boxfit({maximum_font_size: 112, align_center: false});
                    $('#body').boxfit({multiline: true, maximum_font_size: 84, align_middle: false, align_center: false});
                }, 500);
            }
        });
    } else {
        $.ajax({
            type: 'GET',
            url: url,
            data: { action: "next", data: currentId },
            dataType: 'json',
            success: function (data) {
                currentId = data["id"];
                var nextColor = data["color"];
                $("#notice-container").fadeOut();
                $("body").css({ backgroundColor: "#"+nextColor});
                setTimeout(function() {
                    $("#body-js-cont").html('<div id="body" style="height:740px;width:1200px;" class="body container">'+data['body']+'</div>');
                    $("#title-js-cont").html('<div id="title" style="height:180px;width:1200px;" class="title container">'+data['title']+'</div>');
                    $('#title').boxfit({maximum_font_size: 112, align_center: false});
                    $('#body').boxfit({multiline: true, maximum_font_size: 84, align_middle: false, align_center: false});
                    $("#notice-container").fadeIn();
                }, 390);
                setTimeout(function() {
                    $('#title').boxfit({maximum_font_size: 112, align_center: false});
                    $('#body').boxfit({multiline: true, maximum_font_size: 84, align_middle: false, align_center: false});
                }, 400)
                setTimeout(function() {
                    $('#title').boxfit({maximum_font_size: 112, align_center: false});
                    $('#body').boxfit({multiline: true, maximum_font_size: 84, align_middle: false, align_center: false});
                }, 500);
            }
        });
    }
}

function doBanner() {
    $.ajax({
        url: 'https://notices.techybyte.co.uk/api/fetchFact.php',
        data: { m: mr, d: d },
        dataType: 'text',
        type: 'GET',
        async: true,
        success: function (data) {
            $("#scrolling").html("King Edward VI Camp Hill School for Boys - "+d+nth(d)+" "+m+" "+y+currentWeek+" - "+data);
        }
    });
}

function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    h = checkTime(h);
    $("#footerl").html(h + ":" + m + ":" + s);
    var t = setTimeout(startTime, 500);
}

var currentWeek = "";

function getWeek() {
    $.ajax({
        type: 'GET',
        url: "https://notices.techybyte.co.uk/home/notices/week.php",
        dataType: 'json',
        success: function (data) {
            var week;
            switch (data["code"]) {
                case "A":
                    week = " (Week A)";
                    break;
                case "B":
                    week = " (Week B)";
                    break;
                case "WA":
                    week = " (Week B)";
                    break;
                case "WB":
                    week = " (Week A)";
                    break;
                default:
                    week = ""
            }
            currentWeek = week;
        }
    });
}

function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}

getWeek();

setTimeout(function() {
    doBanner();
}, 2000);

setInterval(getWeek(), 50*60*1000);
setInterval(doBanner(), 50*60*1000);

startTime();

setTimeout(function(){
    update();
    setInterval(function(){update();}, 10000);
}, 2250);

setTimeout(function() {
    $('#title').boxfit({maximum_font_size: 112, align_center: false});
    $('#body').boxfit({multiline: true, maximum_font_size: 84, align_middle: false, align_center: false});
}, 50);

/* setInterval(function(){
    $('#title').boxfit({maximum_font_size: 112, align_center: false});
    $('#body').boxfit({multiline: true, maximum_font_size: 84, align_middle: false, align_center: false});
    setTimeout(function() {
        $('#title').boxfit({maximum_font_size: 112, align_center: false});
        $('#body').boxfit({multiline: true, maximum_font_size: 84, align_middle: false, align_center: false});
        setTimeout(function() {
            $('#title').boxfit({maximum_font_size: 112, align_center: false});
            $('#body').boxfit({multiline: true, maximum_font_size: 84, align_middle: false, align_center: false});
        }, 90)
    }, 90)
}, 1000); */