$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var restaurants;
var idR;

var main = function() {
    sortButtonGeneral();
    $("#general").click(sortButtonGeneral);
    $("#kitchen").click(sortButtonKitchen);
    $("#interier").click(sortButtonInterier);
    $("#service").click(sortButtonService);
    $(".descr").click(showModal);
    $("#modal-save").click(saveRating);
};

var showModal = function() {
    idR = $(this).children().attr('data-id');
    var id = $(this).parent().parent().attr("id");
    $(".modal-title").text(restaurants[id].name);
    $(".modal-body").find("img").attr("src", restaurants[id].img);
    $("#modal-general").find(".modal-center").empty();
    $("#modal-kitchen").find(".modal-center").empty();
    $("#modal-interier").find(".modal-center").empty();
    $("#modal-service").find(".modal-center").empty();
    if (admin==0) {
        for (var i = 1; i <= 5; i++) {
            if (i <= Math.round(restaurants[id].generalMark))
                $("#modal-general").find(".modal-center").append('<img id="'+i+'"src="img/star.png" class="modal-star img-responsive">');

            if (i <= Math.round(restaurants[id].kitchenMark))
                $("#modal-kitchen").find(".modal-center").append('<img id="'+i+'"src="img/star.png" class="modal-star img-responsive">');

            if (i <= Math.round(restaurants[id].interierMark))
                $("#modal-interier").find(".modal-center").append('<img id="'+i+'"src="img/star.png" class="modal-star img-responsive">');

            if (i <= Math.round(restaurants[id].serviceMark))
                $("#modal-service").find(".modal-center").append('<img id="'+i+'"src="img/star.png" class="modal-star img-responsive">');
        }

        $(".modal-body").children("p").text(restaurants[id].review);
        $("#modal").modal('show');
        $("#modal-save").hide();
    }
    else {
        for (var i = 1; i <= 5; i++) {
            if (i <= Math.round(restaurants[id].generalMark))
                $("#modal-general").find(".modal-center").append('<img id="'+i+'"src="img/star.png" class="modal-star img-responsive">');
            else
                $("#modal-general").find(".modal-center").append('<img id="'+i+'"src="img/star-empty.png" class="modal-star img-responsive">');

            if (i <= Math.round(restaurants[id].kitchenMark))
                $("#modal-kitchen").find(".modal-center").append('<img id="'+i+'"src="img/star.png" class="modal-star img-responsive">');
            else
                $("#modal-kitchen").find(".modal-center").append('<img id="'+i+'"src="img/star-empty.png" class="modal-star img-responsive">');

            if (i <= Math.round(restaurants[id].interierMark))
                $("#modal-interier").find(".modal-center").append('<img id="'+i+'"src="img/star.png" class="modal-star img-responsive">');
            else
                $("#modal-interier").find(".modal-center").append('<img id="'+i+'"src="img/star-empty.png" class="modal-star img-responsive">');

            if (i <= Math.round(restaurants[id].serviceMark))
                $("#modal-service").find(".modal-center").append('<img id="'+i+'"src="img/star.png" class="modal-star img-responsive">');
            else
                $("#modal-service").find(".modal-center").append('<img id="'+i+'"src="img/star-empty.png" class="modal-star img-responsive">');
        }

        $(".modal-body").children("p").text(restaurants[id].review);
        $("#modal").modal('show');
        readyStars();
    }
};

var sortButtonGeneral = function() {
    $.ajax({
        method: 'post',
        url: 'loadRestaurantsSortedByGeneral',
        dataType: 'json',
        success: function(data) {
            restaurants=data;
            doSort();
        }
    });
    $(".btn.btn-primary").removeClass("selected");
    $("#general").addClass("selected");
};

var sortButtonKitchen = function() {
    $.ajax({
        method: 'post',
        url: 'loadRestaurantsSortedByKitchen',
        dataType: 'json',
        success: function(data) {
            restaurants=data;
            doSort();
        }
    });
    $(".btn.btn-primary").removeClass("selected");
    $("#kitchen").addClass("selected");
    doSort();
};

var sortButtonInterier = function() {
    $.ajax({
        method: 'post',
        url: 'loadRestaurantsSortedByInterier',
        dataType: 'json',
        success: function(data) {
            restaurants=data;
            doSort();
        }
    });
    $(".btn.btn-primary").removeClass("selected");
    $("#interier").addClass("selected");
    doSort();
};

var sortButtonService = function() {
    $.ajax({
        method: 'post',
        url: 'loadRestaurantsSortedByService',
        dataType: 'json',
        success: function(data) {
            restaurants=data;
            doSort();
        }
    });
    $(".btn.btn-primary").removeClass("selected");
    $("#service").addClass("selected");
    doSort();
};

var doSort = function() {
    $(".center-block.container.main").empty();

    var a = 0;
    while (a < restaurants.length) {
        for (var i = 0; i < 3 ; i++) {
            $(".center-block.container.main").append("<div class=\"row\"></div>");
            var curRow =  $(".center-block.container.main").children(".row").eq(i);
            for (var j = 0; j < 3 ; j++) {
                if (a < restaurants.length) {
                    curRow.append("<div class=\"col-xs-6 col-md-4\"></div>");
                    var curCol = curRow.children(".col-xs-6.col-md-4").eq(j);
                    
                    curCol.append("<div id=\""+ a +"\"class=\"container-fluid element\"></div>");
                    var curElem = curCol.children(".container-fluid.element").first();

                    curElem.append("<div class=\"container name\"><h2>"+ restaurants[a].name +"</h2></div>");
                    curElem.append("<div class=\"container-fluid content\"></div>");
                    curElem.children(".container-fluid.content").append("<div class=\"container image\"><img src=\""+ restaurants[a].img +"\" class=\"img-responsive\"></div>");
                    curElem.find(".container.image").append("<div class=\"image-over\"><div class=\"row\"><div class=\"crit col-xs-9 col-md-6\">Общая<br>Кухня<br>Интерьер<br>Сервис</div><div class=\"stars col-xs-9 col-md-6\"></div></div></div>");
                    for (var m = 0; m < Math.round(restaurants[a].generalMark); m++) {
                        curElem.find(".stars.col-xs-9.col-md-6").last().append("<img src=\"img/star.png\" class=\"star img-responsive\">");
                    }
                    curElem.find(".stars.col-xs-9.col-md-6").last().append("<br>");
                    
                    for (var m = 0; m < Math.round(restaurants[a].kitchenMark); m++) {
                        curElem.find(".stars.col-xs-9.col-md-6").last().append("<img src=\"img/star.png\" class=\"star img-responsive\">");
                    }
                    curElem.find(".stars.col-xs-9.col-md-6").last().append("<br>");
                    
                    for (var m = 0; m < Math.round(restaurants[a].interierMark); m++) {
                        curElem.find(".stars.col-xs-9.col-md-6").last().append("<img src=\"img/star.png\" class=\"star img-responsive\">");
                    }
                    curElem.find(".stars.col-xs-9.col-md-6").last().append("<br>");
                    
                    for (var m = 0; m < Math.round(restaurants[a].serviceMark); m++) {
                        curElem.find(".stars.col-xs-9.col-md-6").last().append("<img src=\"img/star.png\" class=\"star img-responsive\">");
                    }
                    curElem.children(".container-fluid.content").append("<div class=\"container text\"><br><img class=\"map-icon\" src=\"img/map.jpg\">&nbsp;&nbsp;"+ restaurants[a].address +"</div>");
                    curElem.children(".container-fluid.content").append("<a class=\"descr\"><span  data-id=\"" + restaurants[a].id + "\">Подробнее</span></a>");
                    curElem.children(".container-fluid.content").append("<a class=\"showOnMap\"><span data-mapid=\"" + restaurants[a].id + "\">Показать на карте</span></a>");
                    /*curElem.children(".container-fluid.content").append("<br><span class=\"tags\">Тэги: </span>");
                    curElem.children(".container-fluid.content").append("<span class=\"tag\">япония</span>"); */

                    a++;
                    }
                }
        }
    }
    $(".descr").click(showModal);
    $('[data-mapid]').bind('click', function() {
        var id1 = $(this).attr('data-mapid');
        $.get("getCoords", {id: id1}, function (data) {
            var latlng = data.split('|');
            var pos = {
                lat: Number(latlng[0]),
                lng: Number(latlng[1])
            };
            map.setZoom(18);
            map.setCenter(pos);
            window.location.hash = id1;
            setMap();
        });
    });
};

var fillStar = function (modal, q) {
	var stars = $('#' + modal).find(".modal-star");
    
	for (i=0; i<q; i++) {
			$(stars[i]).attr("src", "img/star.png");
		}
    
	for (i=5; i>=q; i--) {
			$(stars[i]).attr("src", "img/star-empty.png");
	}
};

var readyStars = function() {
    var rate = 0;
    $('.modal-center').mouseenter(function(){
        rate = $(this).children('img[src$=\"img/star.png\"]').last().attr("id"); 
        if (rate == undefined) rate = 0;
    });
    
    $('.modal-center').mouseleave(function(){
        var modal = $(this).parent().parent().attr("id");
		fillStar(modal, rate);
        rate = 0;
	});
    
	$('.modal-star').mouseenter(function(){
		var ind = $(this).attr("id");
        var modal = $(this).parent().parent().parent().attr("id");
		fillStar(modal, ind);
	});

	$('.modal-star').click(function(){
		rate = $(this).attr("id");
	});
};

var saveRating = function() {
    var generalMark = $("#modal-general").children(".modal-stars").children(".modal-center").children('img[src$=\"img/star.png\"]').last().attr("id"); 
    var kitchenMark = $("#modal-kitchen").children(".modal-stars").children(".modal-center").children('img[src$=\"img/star.png\"]').last().attr("id"); 
    var interierMark = $("#modal-interier").children(".modal-stars").children(".modal-center").children('img[src$=\"img/star.png\"]').last().attr("id"); 
    var serviceMark = $("#modal-service").children(".modal-stars").children(".modal-center").children('img[src$=\"img/star.png\"]').last().attr("id");
    $.ajax({
        method: 'get',
        url: 'saveRestaurantRating',
        data: {
            'generalMark': generalMark,
            'kitchenMark': kitchenMark,
            'interierMark': interierMark,
            'serviceMark': serviceMark,
            'idR': idR
        },
        success: function() {
            alert("Данные успешно сохранены");
        }
    });
    doSort();
};


$(document).ready(main);
