	var map;
	function initMap() {
		map = new google.maps.Map(document.getElementById('map'), {
		center: {lat: -34.397, lng: 150.644},
		zoom: 15
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
	
	function confirmReg() {
		var Login=document.getElementById('fieldLogin').value;
		var Password=document.getElementById('fieldPassword').value;
		var PasswordConfirm=document.getElementById('fieldPasswordConfirm').value;
		if (Login==""||Password==""||PasswordConfirm=="") alert("Заполните все поля!");
		else {
			if (Login.match(/^[a-z0-9]+$/i)&&Password.match(/^[a-z0-9]+$/i)) {
				if (Password==PasswordConfirm) {
					$.ajax({
						method: 'post',
						url: 'register.php',
						data: {
						'Login': Login,
						'Password': Password,
						'ajax': true
						},
						success: function(data) {
							if (data==1) {
								alert("Регистрация успешна!");
								window.location.href='index.php';
							}
							if (data==-1) alert("Такой логин уже зарегистрирован!");
						}
					});
				}
				else alert("Пароли должны совпадать!");
			}
			else alert("Поля могут содержать только цифры и латинские буквы!");
		}
	}
	
	function callReg() {
		window.location.href='reg.php';
	}
	
	function signOut() {
		$.ajax({
			method: 'post',
			url: 'signout.php',
			data: {
			'ajax': true
			},
			success: function(data) {
				location.reload();
			}
		});
	}
	
	function signIn() {
		var Login=document.getElementById('fieldLogin').value;
		var Password=document.getElementById('fieldPassword').value;
		if (Login==""||Password=="") alert("Заполните все поля!");
		$.ajax({
			method: 'post',
			url: 'signin.php',
			data: {
			'Login': Login,
			'Password': Password,
			'ajax': true
			},
			success: function(data) {
				if (data==1) location.reload();
				if (data==-1) alert("Неправильный логин/пароль!");
			}
		});
	}