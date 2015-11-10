$(document).ready(function() {
	loadRests();
});

function showDescr(a) {
	$('#description' + a).slideToggle();
}

function loadRests() {
	$.ajax({
		method: 'post',
		url: 'getRestCount.php',
		success: function(data) {
			for (var i=1; i<=data; i++) {
				$.ajax({
					method: 'post',
					data: {
					'id': i
					},
					url: 'getRests2.php',
					success: function(data1) {
						$('#restlist').append(data1);
					}
				});
			}
		}
	});
}
