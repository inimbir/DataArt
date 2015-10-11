	var map;
	var loaded;
	
	function initMap() {
		map = new google.maps.Map(document.getElementById('map'), {
			center: {lat: -34.397, lng: 150.644},
			zoom: 15
		});
		var noPoi = [
		  {
			featureType: "poi",
			stylers: [
			  { visibility: "off" }
			]   
		  },
		  {
		    featureType: "transit",
		    stylers: [
			 { visibility: "off" }
		    ]
		  }
		];
		map.setOptions({styles: noPoi});
		
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
		
		google.maps.event.addListener(map, 'tilesloaded', function() {
			[].slice.apply(document.querySelectorAll('#map a')).forEach(function(item) {
				item.setAttribute('tabindex','-1');
			});
			if (!loaded) {
				getRestaurants();
				loaded=true;
			}
		});
	}

	var Marker=false;
	var MarkerListener;
	
	function addRest() {
		document.getElementById('RestInfo').innerHTML='';
		document.getElementById('placingTip').innerHTML="Вы можете установить расположение нового ресторана при помощи клика на карте!";
		MarkerListener = google.maps.event.addListener(map, 'click', function(event) {
			if (!Marker) addMarker(event.latLng, map);
			else Marker.setPosition(event.latLng);
		});
		document.getElementById('addRest').disabled=true;
		document.getElementById('newRestInfo').innerHTML='<br>Название ресторана: <input id="nameRest"><br><br><button disabled class="signbutton" id="saveNewRest" onclick="saveRest()">Сохранить</button><button class="signbutton" id="cancel" onclick="cancel()">Отмена</button>';
	}
	
	function saveRest() {
		var image = {
			scaledSize: new google.maps.Size(32, 32),
			url: '../img/icon.png'
		}
		var Name=document.getElementById('nameRest').value;
		if (Name=="") alert('Название ресторана не может быть пустым!');
		else {
			$.ajax({
				method: 'post',
				url: 'saveRest.php',
				data: {
				'Name': Name,
				'lat': Marker.getPosition().lat(),
				'lng': Marker.getPosition().lng(),
				'ajax': true
				},
				success: function(data) {
					if (data==1) {
						alert("Ресторан успешно добавлен!");
						Marker.setIcon(image);
						Marker.setTitle(Name);
						var mrk=Marker;
						mrk.addListener('click', function() {
							document.getElementById('addRest').disabled=false;
							google.maps.event.removeListener(MarkerListener);
							if (Marker) {
								Marker.setMap(null);
								Marker=false;
							}
							document.getElementById('placingTip').innerHTML='';
							document.getElementById('newRestInfo').innerHTML='';
							document.getElementById('RestInfo').innerHTML="Название: " + mrk.getTitle();
						});
						Marker=false;
						cancel();
					}
					if (data==-1) alert("Ресторан с таким именем уже существует в системе!");
				}
			});
		}
	}
	
	function cancel() {
		document.getElementById('addRest').disabled=false;
		document.getElementById('saveNewRest').disabled=true;
		google.maps.event.removeListener(MarkerListener);
		if (Marker) {
			Marker.setMap(null);
			Marker=false;
		}
		document.getElementById('placingTip').innerHTML='';
		document.getElementById('newRestInfo').innerHTML='';
	}
	
	function addMarker(location, map) {
		document.getElementById('saveNewRest').disabled=false;
		var image = {
			scaledSize: new google.maps.Size(32, 32),
			url: '../img/icon-new.gif'
		}
		Marker = new google.maps.Marker({
			position: location,
			map: map,
			icon: image,
			optimized: false
		});
		document.getElementById('placingTip').innerHTML="Вы можете менять расположение ресторана<br> при помощи клика на карте!";
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
	
	function getRestaurants() {
		var image = {
			scaledSize: new google.maps.Size(32, 32),
			url: '../img/icon.png'
		}
		$.ajax({
			method: 'post',
			url: 'getRests.php',
			data: {
			'ajax': true
			},
			success: function(data) {
				var rests = data.split('|');
				rests.forEach(function(irest, i, rests) {
					var rest=irest.split(',');
					var mrk = new google.maps.Marker({
						position: new google.maps.LatLng(rest[1], rest[2]),
						map: map,
						icon: image,
						title: rest[0],
						optimized: false
					});
					mrk.addListener('click', function() {
						document.getElementById('addRest').disabled=false;
						google.maps.event.removeListener(MarkerListener);
						if (Marker) {
							Marker.setMap(null);
							Marker=false;
						}
						document.getElementById('placingTip').innerHTML='';
						document.getElementById('newRestInfo').innerHTML='';
						document.getElementById('RestInfo').innerHTML="Название: " + mrk.getTitle();
					});
				});
			}
		});
	}