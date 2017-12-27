$(document).ready(function() {
    $.ajax({
        type: 'GET',
        url: "https://isitweeka.com/isitweeka/api.php",
        dataType: 'json',
        success: function (data) {
            var week;
            switch (data["code"]) {
                case "A":
                    week = "It is Week A.";
                    break;
                case "B":
                    week = "It is Week B.";
                    break;
                case "WA":
                    week = "It's currently the weekend, next week will be week A.";
                    break;
                case "WB":
                    week = "It's currently the weekend, next week will be week B.";
                    break;
                case "X":
                    week = "A server-side error has occurred. It may be a holiday, in which case, enjoy it!";
                    break;
                case "H":
                    week = "It's the holiday!";
                    break;
                default:
                    week = "An unknown error has occurred."
            }
            $("#week-title").html(week);
            $("#week-subtitle").html(data["message"]);
            $("#copyright-text").html(data["copyright"]);
            $('body').addClass('loaded');
            $('h1').css('color','#222222');
        }
    });
});