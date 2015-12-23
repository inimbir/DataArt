	var text = "";
	var map;
	var loaded;
	var id=0;

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$showRestInfo = function() {
		$('#list').animate({
			left:'72%'
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

	$(document).ready(function(){
		$('#map').css('height', $(window).height() - $('.header').height() + "px");
		$('#list').css('top', $('.header').height() + "px");
		$('#list').css('height', $(window).height() - $('.header').height() + "px");
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
		$('.userLabelText').focusout(function(){
			var t1 = document.getElementsByClassName('userLabelText')[0].value;
			var id1 = document.getElementsByClassName('userLabelText')[0].id;
			if (text!=t1) {
				$.get("setLabel", {id: id1, text: t1}, function() {
					document.getElementsByClassName('userLabelText')[0].value = t1;
					text=t1;
				});
			}
		});
	});

	$( window ).resize(function() {
		$('#map').css('height', $(window).height() - $('.header').height() + "px");
		$('#list').css('top', $('.header').height() + "px");
		$('#list').css('height', $(window).height() - $('.header').height() + "px");
		$('#slider ul li').css('width', $('#slider').width() + 'px');
		$('#slider .nav div img').css('margin-top', $('#slider .nav div').height()*0.45);
	});

	function startMap() {
		var $preloader = $('#page-preloader'),
			$spinner   = $preloader.find('.spinner');
		$spinner.fadeOut();
		$preloader.delay(350).fadeOut('slow');
		map = new google.maps.Map(document.getElementById('map'), {
			center: {lat: -34.397, lng: 150.644},
			zoom: 15
		});
		drawMore();
	}

	function drawMore() {
		if (moveTo==-1) {
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(function (position) {
					var pos = {
						lat: position.coords.latitude,
						lng: position.coords.longitude
					};
					map.setCenter(pos);
				}, function () {
					alert("Не удалось установить местоположение.");
				});
			}
			else {
				alert("Ваш браузер не поддерживает геолокацию.");
			}
		}
		else {
			$.get("getCoords", {id: moveTo}, function (data) {
				var latlng = data.split('|');
				var pos = {
					lat: Number(latlng[0]),
					lng: Number(latlng[1])
				};
				map.setZoom(18);
				map.setCenter(pos);
			});
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
		$('#userLabel').hide();
		$('#RestReview').hide();
		$('#ShareDiv').hide();
		$('#slider').hide();
		$('#addPhoto').hide();
		$('#editReview').hide();
		$('#marks').hide();
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
								Marker.setLabel(" " + data);
								var mrk=Marker;
								mrk.addListener('click', function() {
									$('#userLabel').show(500);
									$('#RestReview').show(500);
									$('#ShareDiv').show(500);
									$('#slider').show(500);
									$('#marks').show(500);
									document.getElementById('addRest').disabled=false;
									google.maps.event.removeListener(MarkerListener);
									$showRestInfo();
									if (Marker) {
										Marker.setMap(null);
										Marker=false;
									}
									id=mrk.getLabel();
									id=id.substr(1, id.length-1);
									setListMarks();
									window.location.hash = id;
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
		window.location.hash = "";
		$('#userLabel').show(500);
		$('#RestReview').show(500);
		$('#ShareDiv').show(500);
		$('#slider').show(500);
		$('#marks').show(500);
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
		};
		Marker = new google.maps.Marker({
			position: location,
			map: map,
			icon: image,
			optimized: false
		});
		document.getElementById('placingTip').innerHTML="Вы можете менять расположение ресторана<br> при помощи клика на карте!";
	}
	
	function getRestaurants() {
		var image = {
			scaledSize: new google.maps.Size(32, 32),
			url: 'img/icon.png'
		};
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
						label: " " + rest[0],
						optimized: false
					});
					mrk.addListener('click', function() {
						google.maps.event.removeListener(MarkerListener);
						$showRestInfo();
						if (Marker) {
							Marker.setMap(null);
							Marker=false;
						}
						id=mrk.getLabel();
						id=id.substr(1, id.length-1);
						setListMarks();
						$('#userLabel').show(500);
						$('#RestReview').show(500);
						$('#ShareDiv').show(500);
						$('#slider').show(500);
						$('#marks').show(500);
						document.getElementById('placingTip').innerHTML='';
						document.getElementById('newRestInfo').innerHTML='';
						if (document.getElementById('userLabel').innerHTML!="0") {
							document.getElementsByClassName('userLabelText')[0].id = id;
							$.get("getLabel", {id: id}, function (data) {
								var d = data.toString();
								document.getElementsByClassName('userLabelText')[0].value = d;
								text = d;
							});
						}
						window.location.hash = id;
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
								$.get("isAdmin", function (data) {
									if (data==1) {
										if (gotRest[1]=='') {
											document.getElementById('editReview').onclick=function() {editReview(0);};
											document.getElementById('editReview').innerHTML="Добавить рецензию";
										}
										else {
											document.getElementById('editReview').onclick=function() {editReview(1);};
											document.getElementById('editReview').innerHTML="Изменить рецензию";
										}
										document.getElementById('addRest').disabled=false;
									}
								});
							}
						});
						loadPhotos();
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
	};
	
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
		Share.vkontakte('http://resojlda.pe.hu/#' + id,title2,'IMG_PATH',review2);
	}
	
	function shareFB() {
		var title = document.getElementById('RestInfo').innerHTML;
		var title2 = title.substr(10);
		var review = document.getElementById('RestReview').innerHTML;
		var review2 = review.substr(22);
		Share.facebook('http://resojlda.pe.hu/#' + id,title2,'IMG_PATH',review2);
	}
	
	function shareTW() {
		var title = document.getElementById('RestInfo').innerHTML;
		var title2 = title.substr(10);
		Share.twitter('http://resojlda.pe.hu/#' + id,'Увидел крутую рецензию на ресторан ' + title2 + " на этом сайте. ;)");
	}

function deleteRest() {
	 if (confirm("Вы действительно хотите удалить данный ресторан?")) {
		window.location.hash = "";
		$.ajax({
			method: 'get',
			url: 'deleteRest',
			data: {
				'id': id
			},
			success: function () {
				location.reload();
			}
		});
	}
 }	

var setListMarks = function() {
	$.ajax({
		method: 'get',
		url: 'loadRestaurantMarks',
		dataType: 'json',
		data: {
			'id': id
		},
		success: function(restaurants) {
			$("#general-stars").empty();
			$("#kitchen-stars").empty();
			$("#interior-stars").empty();
			$("#service-stars").empty();
			if (admin==0) {
				for (var i = 1; i <= 5; i++) {
					if (i <= Math.round(restaurants[0].generalMark))
						$("#general-stars").append('<img id="'+i+'"src="img/star.png" class="star img-responsive">');

					if (i <= Math.round(restaurants[0].kitchenMark))
						$("#kitchen-stars").append('<img id="'+i+'"src="img/star.png" class="star img-responsive">');

					if (i <= Math.round(restaurants[0].interierMark))
						$("#interior-stars").append('<img id="'+i+'"src="img/star.png" class="star img-responsive">');

					if (i <= Math.round(restaurants[0].serviceMark))
						$("#service-stars").append('<img id="'+i+'"src="img/star.png" class="star img-responsive">');
				}
			}
			else {
				for (var i = 1; i <= 5; i++) {
					if (i <= Math.round(restaurants[0].generalMark))
						$("#general-stars").append('<img id="'+i+'"src="img/star.png" class="star img-responsive">');
					else
						$("#general-stars").append('<img id="'+i+'"src="img/star-empty.png" class="star img-responsive">');

					if (i <= Math.round(restaurants[0].kitchenMark))
						$("#kitchen-stars").append('<img id="'+i+'"src="img/star.png" class="star img-responsive">');
					else
						$("#kitchen-stars").append('<img id="'+i+'"src="img/star-empty.png" class="star img-responsive">');

					if (i <= Math.round(restaurants[0].interierMark))
						$("#interior-stars").append('<img id="'+i+'"src="img/star.png" class="star img-responsive">');
					else
						$("#interior-stars").append('<img id="'+i+'"src="img/star-empty.png" class="star img-responsive">');

					if (i <= Math.round(restaurants[0].serviceMark))
						$("#service-stars").append('<img id="'+i+'"src="img/star.png" class="star img-responsive">');
					else
						$("#service-stars").append('<img id="'+i+'"src="img/star-empty.png" class="star img-responsive">');
				}
				readyStars();
			}
		}
	});
};

var fillStar = function (crit, q) {
	var stars = $('#' + crit).children(".star");
    
	for (i=0; i<q; i++) {
			$(stars[i]).attr("src", "img/star.png");
		}
    
	for (i=5; i>=q; i--) {
			$(stars[i]).attr("src", "img/star-empty.png");
	}
};

var readyStars = function() {
    var rate = 0;
    $('.p-stars').mouseenter(function(){
        rate = $(this).children('img[src$=\"img/star.png\"]').last().attr("id");
        if (rate == undefined) rate = 0;
    });

    $('.p-stars').mouseleave(function(){
        var crit = $(this).attr("id");
		fillStar(crit, rate);
        rate = 0;
	});

	$('.star').mouseenter(function(){
		var ind = $(this).attr("id");
        var crit = $(this).parent().attr("id");
		fillStar(crit, ind);
	});

	$('.star').click(function(){
		rate = $(this).attr("id");
		var critName = $(this).parent().attr("id").split("-")[0];
		$.ajax({
			method: 'get',
			url: 'setRestaurantMark',
			data: {
				'id': id,
				'markType': critName,
				'rate': rate
			}
		});
	});
};