var map;
	function initMap() {
		map = new google.maps.Map(document.getElementById('map'), {
		center: {lat: -34.397, lng: 150.644},
		zoom: 13
		});
		var infoWindow = new google.maps.InfoWindow({map: map});
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function(position) {
			  var pos = {
				lat: position.coords.latitude,
				lng: position.coords.longitude
			  };
			  infoWindow.setPosition(pos);
			  infoWindow.setContent('Вы');
			  map.setCenter(pos);
			}, function() {
			  handleLocationError(true, infoWindow, map.getCenter());
			});
		} 
		else {
			// Browser doesn't support Geolocation
			handleLocationError(false, infoWindow, map.getCenter());
		}

		google.maps.event.addListener(map, 'click', function(event) {
			addMarker(event.latLng, map);
		});
	}

	function addMarker(location, map) {
		var image = {
			scaledSize: new google.maps.Size(32, 32),
			url: '../img/icon.png'
		}
		var marker = new google.maps.Marker({
			position: location,
			map: map,
			icon: image
		});
		marker.addListener('click', function() {
			document.getElementById('plist').innerHTML="Координаты выбранной отметки:<br>" + marker.getPosition();
		});
	}

	function handleLocationError(browserHasGeolocation, infoWindow, pos) {
			infoWindow.setPosition(pos);
			infoWindow.setContent(browserHasGeolocation ?
							'Не удалось определить Ваше местоположение.' :
							'Ваш браузер не поддерживает автоматическое определение Вашего местоположения.'
							);
	}