function loadSlider() {
	$("#slider").each(function () {
	  var obj = $(this);
	  $(obj).append("<div class='nav'></div>");
	  $(obj).find("li").each(function () {
		$(this).attr("id", $(this).index());
	  });
	  $(obj).find("li").first().addClass("on"); 
	  $(obj).find(".nav").append("<div class='next'><img src='img/next.png'></div>");
	  $(obj).find(".nav").append("<div class='prev'><img src='img/prev.png'></div>");
	});
};

function slide (str, sl) { 
	var ul = $(sl).find("ul"); 
	var bl = $(sl).find("li.on");
	var step = $(bl).width();
	
	
	if (str === "next") {
		if ($(bl).attr("id") == $(sl).find("li").last().attr("id")) {
			var newActive = sl.find("li").first();
		} else { var newActive = $(bl).next(); }
	}
	if (str === "prev") {
		if ($(bl).attr("id") == 0) {
			var newActive = $(sl).find("li").last();
		} else {var newActive = $(bl).prev();}
	}
	
	$(bl).removeClass("on");
	$(newActive).addClass("on");
	var num = $(newActive).attr("id");
	
	$(ul).animate({marginLeft: "-"+step*num}, 500);
}

$(document).on("click", "#slider .nav .prev", function() {
	var sl = $(this).closest("#slider");
	slide("prev", sl);
});

$(document).on("click", "#slider .nav .next", function() {
	var sl = $(this).closest("#slider");
	slide("next", sl);
});