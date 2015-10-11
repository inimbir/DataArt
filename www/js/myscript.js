$(document).ready(function() {
    $(".open-descr p").click(function() {
        $(this).parent().parent().parent().parent().children("div.descr").slideToggle(); 
    });
});


/*$(document).ready(function() {
    $(".open-descr p").click(function() {
        $(this).parent().parent().children("div.descr").slideToggle();
    });
});*/