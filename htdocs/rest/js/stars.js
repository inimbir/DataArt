function fillStar(q){
	var stars = document.getElementsByClassName("modal-star");
	for (i=0; i<q; i++){
			$(stars[i]).attr("src", "star.png");
		}
	for (i=5; i>=q; i--){
			$(stars[i]).attr("src", "star-empty.png");
	}
}
$(document).ready(function() {
	var rate = 0;
	$('.modal-star').mouseenter(function(){
		var ind = $(this).attr("id");
		fillStar(ind);
	});
	$('#rateStars').mouseleave(function(){
		fillStar(rate);
	});
	$('.modal-star').click(function(){
		rate = $(this).attr("id");
		alert(rate);
	});
});
