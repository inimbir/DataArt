$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

$(document).ready(function() {
	loadRests();
});

function showDescr(a) {
	$('#description' + a).slideToggle();
}

function loadRests() {
	$.ajax({
		method: 'post',
		url: 'countRests',
		success: function(data) {
			var restIds = data.split('.');
			restIds.forEach(function(restId) {
				$.ajax({
					method: 'post',
					data: {
						'id': restId
					},
					url: 'loadRestaurantsForRatingList',
					success: function(data1) {
						$('#restlist').append(data1);
					}
				});
			});
		}
	});
}
