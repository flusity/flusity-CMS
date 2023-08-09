$(document).ready(function(){
    $(".nav-item").hover(function(){
        $(this).find(".submenu").stop(true, true).delay(200).fadeIn(500);
    }, function() {
        $(this).find(".submenu").stop(true, true).delay(200).fadeOut(500);
    });
});