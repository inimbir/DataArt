	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$showRestInfo = function() {
		$('#list').animate({
			left:'70%'
		});
		$('#addPhoto').show();
		$('#editReview').show();
	};
	
	$hideRestInfo = function() {
		$('#list').animate({
			left:'100%'
		});
		cancel();
	};

	function initMap() {}

	$(document).ready(function(){
		$('#addPhoto').hide();
		$('#editReview').hide();
		$('#saveReview').hide();
		$('#closeList').click(function(){
			$hideRestInfo();
		});
		$("#signup").click(function () {
			$("#popup").show(1000);
		});

		$("#close_popup").click(function () {
			$("#popup").hide(1000);
		});
	});
	
	$(window).on('load', function () {
		var $preloader = $('#page-preloader'),
			$spinner   = $preloader.find('.spinner');
		$spinner.fadeOut();
		$preloader.delay(350).fadeOut('slow');
		$("#gmap").load(startMap());
	});

	
	var map;
	var loaded;
	var id=0;
	
	
	function startMap() {
		map = new google.maps.Map(document.getElementById('map'), {
			center: {lat: -34.397, lng: 150.644},
			zoom: 15
		});
		drawMore();
	}

	function drawMore() {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function(position) {
			  var pos = {
				lat: position.coords.latitude,
				lng: position.coords.longitude
			  };
			  map.setCenter(pos);
			}, function() {
			  alert("Не удалось установить местоположение.");
			});
		} 
		else {
			alert("Ваш браузер не поддерживает геолокацию.");
		}
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
		google.maps.event.addListener(map, 'tilesloaded', function() {
			[].slice.apply(document.querySelectorAll('#map a')).forEach(function(item) {
				item.setAttribute('tabindex','-1');
			});
			if (!loaded) {
				getRestaurants();
				loaded=true;
			}
		});
		if (document.getElementById('map').innerHTML="") location.reload();
	}
	
	var Marker=false;
	var MarkerListener;
	
	function addRest() {
		$showRestInfo();
		$('#addPhoto').hide();
		$('#editReview').hide();
		document.getElementById('RestInfo').innerHTML='';
		document.getElementById('placingTip').innerHTML="Вы можете установить расположение нового ресторана при помощи клика на карте!";
		MarkerListener = google.maps.event.addListener(map, 'click', function(event) {
			if (!Marker) addMarker(event.latLng, map);
			else Marker.setPosition(event.latLng);
		});
		document.getElementById('addRest').disabled=true;
		document.getElementById('newRestInfo').innerHTML='<br>Название ресторана: <input id="nameRest"><br><br><button disabled class="signbutton" id="saveNewRest" onclick="saveRest()">Сохранить</button><button class="signbutton" id="cancel" onclick="cancel()">Отмена</button>';
		document.getElementById('slider').innerHTML='';
	}
	
	function saveRest() {
		var image = {
			scaledSize: new google.maps.Size(32, 32),
			url: 'img/icon.png'
		};
		var Name=document.getElementById('nameRest').value;
		if (Name=="") alert('Название ресторана не может быть пустым!');
		else {
			if (Name.match(/^[a-zа-яё0-9\s]+$/i)){
				var adress;
				var lat = Marker.getPosition().lat();
				var lng = Marker.getPosition().lng();
				$.getJSON("getAdr/" + lat + "," + lng, function(data1) {
					adress = data1["results"][0].formatted_address;
					$.ajax({
						method: 'post',
						url: 'saveRest',
						data: {
						'Name': Name,
						'lat': lat,
						'lng': lng,
						'adr': adress
						},
						success: function(data) {
							if (data!=-1) {
								alert("Ресторан успешно добавлен!");
								Marker.setIcon(image);
								Marker.setTitle(data);
								var mrk=Marker;
								mrk.addListener('click', function() {
									document.getElementById('addRest').disabled=false;
									google.maps.event.removeListener(MarkerListener);
									$showRestInfo();
									if (Marker) {
										Marker.setMap(null);
										Marker=false;
									}
									id=mrk.getTitle();
									document.getElementById('placingTip').innerHTML='';
									document.getElementById('newRestInfo').innerHTML='';
									$.ajax({
										method: 'post',
										url: 'getRestInfo',
										data: {
											'id': id
										},
										success: function(data) {
											var gotRest = data.split('|');
											$('#saveReview').hide();
											document.getElementById('RestInfo').innerHTML="Название: " + gotRest[0];
											document.getElementById('RestReview').innerHTML="&nbsp;&nbsp;Рецензия: " + gotRest[1];
											if (gotRest[1]=='') {
												document.getElementById('editReview').onclick=function() {editReview(0);};
												document.getElementById('editReview').innerHTML="Добавить рецензию";
											}
											else {
												document.getElementById('editReview').onclick=function() {editReview(1);};
												document.getElementById('editReview').innerHTML="Изменить рецензию";
											}
										}
									});
									loadPhotos();
									Marker=false;
								});
								Marker=false;
								cancel();
							}
							if (data==-1) alert("Ресторан с таким именем уже существует в системе!");
						}
					});
				});
			}
			else alert("Название ресторана может включать только буквы и цифры!")
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
		$hideRestInfo();
	}
	
	function addMarker(location, map) {
		document.getElementById('saveNewRest').disabled=false;
		var image = {
			scaledSize: new google.maps.Size(32, 32),
			url: 'img/icon-new.gif'
		}
		Marker = new google.maps.Marker({
			position: location,
			map: map,
			icon: image,
			optimized: false
		});
		document.getElementById('placingTip').innerHTML="Вы можете менять расположение ресторана<br> при помощи клика на карте!";
	}
	
	function confirmReg() {
		var Login=document.getElementById('regLogin').value;
		var Password=document.getElementById('regPassword').value;
		var PasswordConfirm=document.getElementById('regPasswordConfirm').value;
		if (Login==""||Password==""||PasswordConfirm=="") alert("Заполните все поля!");
		else {
			if (Login.match(/^[a-z0-9]+$/i)&&Password.match(/^[a-z0-9]+$/i)) {
				if (Password==PasswordConfirm) {
					$.ajax({
						method: 'post',
						url: 'register',
						data: {
						'Login': Login,
						'Password': Password,
						'ajax': true
						},
						success: function(data) {
							if (data==1) {
								alert("Регистрация успешна!");
								$("#popup").hide(1000);
								location.reload();
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
	
	function signOut() {
		$.ajax({
			method: 'post',
			url: 'signout',
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
			url: 'signin',
			data: {
				'Login': Login,
				'Password': Password
			},
			success: function(data) {
				if (data==1) location.reload();
				if (data==-1) alert("Неправильный логин/пароль!");
			},
			erro: function(error) {
				alert(error);
			}
		});
	}
	
	function getRestaurants() {
		var image = {
			scaledSize: new google.maps.Size(32, 32),
			url: 'img/icon.png'
		}
		$.ajax({
			method: 'post',
			url: 'loadRestaurantsForMap',
			success: function(data) {
				var rests = data.split('|');
				rests.forEach(function(irest, i, rests) {
					var rest=irest.split(',');
					var mrk = new google.maps.Marker({
						position: new google.maps.LatLng(rest[2], rest[3]),
						map: map,
						icon: image,
						title: rest[0],
						optimized: false
					});
					mrk.addListener('click', function() {
						google.maps.event.removeListener(MarkerListener);
						$showRestInfo();
						if (Marker) {
							Marker.setMap(null);
							Marker=false;
						}
						id=mrk.getTitle();
						document.getElementById('placingTip').innerHTML='';
						document.getElementById('newRestInfo').innerHTML='';
						$.ajax({
							method: 'post',
							url: 'getRestInfo',
							data: {
							'id': id
							},
							success: function(data) {
								var gotRest = data.split('|');
								$('#saveReview').hide();
								document.getElementById('RestInfo').innerHTML="Название: " + gotRest[0];
								document.getElementById('RestReview').innerHTML="&nbsp;&nbsp;Рецензия: " + gotRest[1];
								if (gotRest[1]=='') {
									document.getElementById('editReview').onclick=function() {editReview(0);};
									document.getElementById('editReview').innerHTML="Добавить рецензию";
								}
								else {
									document.getElementById('editReview').onclick=function() {editReview(1);};
									document.getElementById('editReview').innerHTML="Изменить рецензию";
								}
							}
						});
						loadPhotos();
						document.getElementById('addRest').disabled=false;
					});
				});
			}
		});
	}
	
	function editReview(a) {
		var SourceReview = document.getElementById('RestReview').innerHTML;
		var ReviewText = SourceReview.substr(22);
		document.getElementById('RestReview').innerHTML='&nbsp;&nbsp;Рецензия:<br><textarea rows="5" style="width:90%;margin-left:15px;margin-right:15px;" id="RestReviewArea"></textarea>';
		document.getElementById('RestReviewArea').innerHTML=ReviewText;
		document.getElementById('editReview').onclick=function() {cancelReview(a,SourceReview);};
		document.getElementById('editReview').innerHTML="Отмена";
		$('#saveReview').show();
	}
	
	function saveReview() {
		var ReviewText = $("#RestReviewArea").val();
		if (ReviewText.length > 999) alert("Размер рецензии не должен превышать 1000 символов!");
		else {
			$.ajax({
				method: 'post',
				url: 'updateReview',
				data: {
				'id': id,
				'review': ReviewText
				},
				success: function() {
					document.getElementById('RestReview').innerHTML='&nbsp;&nbsp;Рецензия: ' + ReviewText;
					document.getElementById('editReview').onclick=function() {editReview(1);};
					document.getElementById('editReview').innerHTML="Изменить рецензию";
				}
			});
		}
		$('#saveReview').hide();
	}
	
	function cancelReview(a,review) {
		$('#saveReview').hide();
		if (a==0) {
			document.getElementById('RestReview').innerHTML=review;
			document.getElementById('editReview').onclick=function() {editReview(0);};
			document.getElementById('editReview').innerHTML="Добавить рецензию";
		}
		else {
			document.getElementById('RestReview').innerHTML=review;
			document.getElementById('editReview').onclick=function() {editReview(1);};
			document.getElementById('editReview').innerHTML="Изменить рецензию";
		}
	}
	
	$callUpload = function() {
		$('#Upload').trigger('click'); 
	}
	
	function uploadPhoto() {
		var data = new FormData();
		if (document.getElementById('Upload').value!="") {
			files=document.getElementById('Upload').files;
			$.each( files, function( key, value ){
				data.append( key, value );
			});
			data.append("id", id);
			$.ajax({
				url: 'upload',
				method: 'POST',
				data: data,
				cache: false,
				processData: false,
				contentType: false,
				success: function(data) {
					loadPhotos();
				}
			});
		}
	}
	
	
	function loadPhotos() {
		document.getElementById('slider').innerHTML='';
		$.ajax({
			method: 'post',
			url: 'loadPhotos',
			data: {
			'id': id,
			'ajax': true
			},
			success: function(data) {
				if (data!="") {
					var photos = data.split('|');
					$('#slider').remove();
					$('.container').append("<div id='slider' style='margin-top:5px;background: rgba(255, 255, 255, 1);'><ul></ul></div>");
					photos.forEach(function(photo, i, photos) {
						$('#slider ul').append("<li><img class='photo' src=\"photos/" + id + "/" + photo + "\"></li>");
					});
					loadSlider();
				}
			}
		});
	}
	
	function shareVK() {
		var title = document.getElementById('RestInfo').innerHTML;
		var title2 = title.substr(10);
		var review = document.getElementById('RestReview').innerHTML;
		var review2 = review.substr(22);
		Share.vkontakte('http://rest-manager.com',title2,'IMG_PATH',review2);
	}
	
	function shareFB() {
		var title = document.getElementById('RestInfo').innerHTML;
		var title2 = title.substr(10);
		var review = document.getElementById('RestReview').innerHTML;
		var review2 = review.substr(22);
		Share.facebook('http://rest-manager.com/',title2,'IMG_PATH',review2);
	}
	
	function shareTW() {
		var title = document.getElementById('RestInfo').innerHTML;
		var title2 = title.substr(10);
		Share.twitter('http://rest-manager.com','Увидел крутую рецензию на ресторан ' + title2 + " на этом сайте. ;)");
	}